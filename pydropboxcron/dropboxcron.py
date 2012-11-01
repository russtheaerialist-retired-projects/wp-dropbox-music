""" For each file in the base directory, dropboxcron locates all mp3 files in
    the directory and uploads into a similar directory on dropbox, and then
    emails the admin to let him know that files have been uploaded """

import sys
import os
import os.path as path
import Queue

from yaml import load as yamlload
from yaml import dump as yamlsave
from phpserialize import loads as phpload

from sqlalchemy import create_engine
from sqlalchemy.sql import select
from sqlalchemy.schema import MetaData

from dropbox import client, rest, session

def load_config(args):
    return {
        'sqlalchemy': {
            'engine': 'mysql+pymysql://root:root@localhost/wordpress',
        },
        'wordpress': {
            'root': '/Applications/MAMP/htdocs/wordpress',
            'prefix': 'wp_',
            'option': 'dropbox-music-settings',
        },
        'dropbox': {
            'access_type': 'app_folder',
        },
    }

def get_options_from_database(config):
    table_name = "%soptions" % config['wordpress']['prefix']
    engine = create_engine(config['sqlalchemy']['engine'])
    meta = MetaData()
    meta.reflect(bind=engine)

    options_table = meta.tables[table_name]
    query = select([options_table.c.option_value],
        options_table.c.option_name==config['wordpress']['option'])

    connection = engine.connect()
    result = connection.execute(query)
    row = result.fetchone()
    values = phpload(row[0])

    return dict([(k.replace("dropbox_music_", ""), v)
                  for k,v in values.items()])

def relative_to_wordpress(config, *args):
    return path.join(config['wordpress']['root'], *args)

def get_token(config, options, sess):
    filename = relative_to_wordpress(config, options['storage_directory'], 'token.txt')
    if path.exists(filename):
        with open(filename, "r") as f:
            return yamlload(f)

    request_token = sess.obtain_request_token()
    url = sess.build_authorize_url(request_token)
    print "url:", url
    print "Please visit this website and press the 'Allow' button, then hit 'Enter' here."
    raw_input()

    token = sess.obtain_access_token(request_token)
    token = (token.key, token.secret)
    with open(filename, "w") as f:
        f.write(yamlsave(token))

    return token

def create_dropbox(config, options):
    APP_KEY = options['apikey']
    APP_SECRET = options['apisecret']
    ACCESS_TYPE = config['dropbox']['access_type']

    sess = session.DropboxSession(APP_KEY, APP_SECRET, ACCESS_TYPE)

    token = get_token(config, options, sess)

    sess.set_token(*token)
    dropbox = client.DropboxClient(sess)

    return dropbox

def enqueue(args, root, files):
    if root.endswith('uploads') or root.endswith('uploads/'):
        return

    (queue, config, options, dropbox) = args
    entry_file = [path.join(root, x) for x in files if x.endswith('.txt')][0]
    mp3s = [path.join(root, x) for x in files
            if path.splitext(x)[1] in options['file_extensions']]

    queue.put((entry_file, mp3s))

def upload(dropbox, source, dest):
    with open(source, "rb") as f:
        try:
            response = dropbox.put_file(dest, f, overwrite=True)
        except rest.ErrorResponse, ex:
            return ex.message

    return "ok"

def dropbox_path(options, filepath):
    return filepath.split(options['storage_directory'])[-1]

def main(argv=sys.argv):
    config = load_config(argv)
    options = get_options_from_database(config)
    dropbox = create_dropbox(config, options)

    process_queue = Queue.Queue()
    file_root = relative_to_wordpress(config, options['storage_directory'])
    path.walk(file_root, enqueue, (process_queue, config, options, dropbox))
    email_message = [ ]

    while(not process_queue.empty()):
        should_delete = True
        (entry_file, mp3_list) = process_queue.get()

        with open(entry_file, "r") as f:
            email_message.append(f.readline().strip())

        result = upload(dropbox, entry_file, dropbox_path(options, entry_file))
        if result != "ok":
            should_delete = False
        for mp3 in mp3_list:
            filename = dropbox_path(options, mp3)
            result = upload(dropbox, mp3, filename)
            if result == "ok":
                os.remove(mp3)
            else:
                should_delete = False
            email_message.append("Uploaded(%s): %s%s" % (result, options['folder'], filename))
            email_message.append("\n---------------------")

        if should_delete:
            os.remove(entry_file)
            os.rmdir(path.dirname(entry_file))

    print "\n".join(email_message)

if __name__ == '__main__':
    main()

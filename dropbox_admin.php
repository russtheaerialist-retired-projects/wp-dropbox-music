<?php

function dropbox_music_admin_menu() {
    add_options_page('Dropbox Music Uploader Settings',
                     'Dropbox Music Uploader',
                     'administrator',
                     __FILE__,
                     'dropbox_music_options');
}

function dropbox_music_admin_init() {
    dropbox_music_register_settings();
}

function dropbox_music_register_settings() {
    register_setting( 'dropbox-music-settings', 'dropbox-music-settings', 'dropbox_music_validate_options' );
    add_settings_section('dropbox-music-auth', 'Dropbox Authentication Settings',
                         'dropbox_music_options_auth_text', 'dropbox-music-settings');
    add_settings_field('dropbox_music_apisecret', 'Dropbox API Secret', 'dropbox_music_apisecret_string',
                       'dropbox-music-settings', 'dropbox-music-auth');
    add_settings_field('dropbox_music_apikey', 'Dropbox API Key', 'dropbox_music_apikey_string',
                       'dropbox-music-settings', 'dropbox-music-auth');
    add_settings_field('dropbox_music_folder', 'Dropbox Folder', 'dropbox_music_folder_string',
                       'dropbox-music-settings', 'dropbox-music-auth');
}

function dropbox_music_validate_options($input) {
    return $input;
}

function dropbox_music_options_auth_text() { ?>
<p>This section contains information for authenticating against dropbox.  This is necessary to be able to upload the files to dropbox.</p>
<?php }

function dropbox_music_settings_field($id) {
    $options = get_option('dropbox-music-settings');
?>
<input id="dropbox_music_<?php echo $id; ?>" name="dropbox-music-settings[dropbox_music_<?php echo $id; ?>]" type="text"
    style="width: 30em;"
    value="<?php echo $options["dropbox_music_" . $id]; ?>" />
    <!-- <?php var_dump($options); ?> -->
<?php
}

function dropbox_music_apikey_string()
{
    dropbox_music_settings_field('apikey');
}

function dropbox_music_apisecret_string()
{
    dropbox_music_settings_field('apisecret');
}

function dropbox_music_folder_string()
{
    dropbox_music_settings_field('folder');
}

function dropbox_music_options() {
    include("dropbox_options.php");
}

?>
from setuptools import setup


setup(
    name="pydropboxcron",
    version="0.1",
    py_modules=["dropboxcron"],
    install_requires=[
        "dropbox-python-sdk",
    ],

    entry_points={
        'console_scripts': [
            'dropboxcron = dropboxcron:main',
        ]
    },

    author="Russell Hay",
    author_email="me@russellhay.com",
    description="Scan a folder for mp3 files and upload them to dropbox, and email admin that they have been uploaded",
)

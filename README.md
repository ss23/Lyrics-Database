Installation:
- Copy all the files somewhere
- Direct your webserver to /path/site/app/webroot
- Rename site/app/Config.default -> /site/app/Config
- Get a nice config in the database.php there
- mkdir -p /path/site/app/tmp/cache/persistent && mkdir /path/site/app/tmp/cache/models && mkdir /path/site/app/tmp/logs
- chmod 777 /path/site/app/tmp -R
- Oh ya, you'll probably want to create the tables in the sql folder first

Python Requirements for Scraping:
- Accurate database constants in config.py
- Third party packages:
    -http://www.crummy.com/software/BeautifulSoup/
    -http://musicbrainz.org/doc/python-musicbrainz2
    -http://mysql-python.sourceforge.net/
    -http://code.google.com/p/python-progressbar/

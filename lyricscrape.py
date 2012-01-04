import htmlentitydefs, re, urllib2, json, sys
from musicbrainz2.utils import extractUuid
from musicbrainz2.webservice import Query, ArtistFilter, WebServiceError
from BeautifulSoup import BeautifulSoup, Tag
import MySQLdb as mdb

# Status printing while scraping
DEBUG_PRINT = True

WIKIA_DOMAIN = 'http://lyrics.wikia.com'
MB_PATTERN = re.compile('^http://musicbrainz.org*')

DB_SERVER = 'localhost'
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'lyricjam'

USAGE = '''
Usage: lyricscrape.py {scrape|import} arg
    Examples:
        scrape file.json
            Scrape and dump JSON results into file.json
        import file.json
            Import file.json into the lyric database
'''

def unescape(text):
    def fixup(m):
        text = m.group(0)
        if text[:2] == "&#":
            # character reference
            try:
                if text[:3] == "&#x":
                    return unichr(int(text[3:-1], 16))
                else:
                    return unichr(int(text[2:-1]))
            except ValueError:
                pass
        else:
            # named entity
            try:
                text = unichr(htmlentitydefs.name2codepoint[text[1:-1]])
            except KeyError:
                pass
        return text # leave as is
    return re.sub("&#?\w+;", fixup, text)

def uuid_from_soup(soup, type = None):
    uuid_link = soup.find('a', href=MB_PATTERN)
    if uuid_link:
        return extractUuid(uuid_link['href'], type)
    else:
        return None

def json_to_db(file_in):
    con = mdb.connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    cur = con.cursor()

    jsonstr = open(file_in, 'r').read()
    print jsonstr
    data = json.loads(jsonstr)
    for artist in data:
        artist_uuid = data[artist]['uuid']
        cur.execute("INSERT INTO artists (`name`, `uuid`) VALUES (%s, %s)", (artist, artist_uuid))
        artist_id = cur.lastrowid
        print artist_id, "-", artist, "-", artist_uuid
        for album in data[artist]['albums']:
            album_uuid = data[artist]['albums'][album]['uuid']
            cur.execute("INSERT INTO albums (`name`, `uuid`) VALUES (%s, %s)", (album, album_uuid))
            album_id = cur.lastrowid
            print "\t", album_id, "-", album, "-", album_uuid
            for song in data[artist]['albums'][album]['songs']:
                lyrics = data[artist]['albums'][album]['songs'][song]['lyrics']
                song_uuid = data[artist]['albums'][album]['songs'][song]['uuid']
                cur.execute("INSERT INTO songs (`name`, `lyrics`, `uuid`) VALUES (%s, %s, %s)", (song, lyrics, song_uuid))
                song_id = cur.lastrowid
                print "\t\t", song_id, "-", song, "-", song_uuid
#                print "\t\t\t", lyrics

                cur.execute("INSERT INTO albums_songs (`song_id`, `album_id`) VALUES (%s, %s)", (song_id, album_id))
                cur.execute("INSERT INTO artists_songs (`song_id`, `artist_id`) VALUES (%s, %s)", (song_id, artist_id))
    con.commit()
    cur.close()
    con.close()

def scrape(file_out):
    data = {}
    soup = BeautifulSoup(urllib2.urlopen('http://lyrics.wikia.com/index.php?title=Category:Artists_A').read())

    # Loop through pages of artists
    while True:
        nexturl = soup('span', {'class':'nextLink'})[0].a
        artists = soup('div', id='mw-pages')[0]('a')

        # Loop through all artists on page
        for artist in [artists[0]]:
#        for artist in artists:
            soup = BeautifulSoup(urllib2.urlopen(WIKIA_DOMAIN+artist['href']).read())
            try:
#                uuid_link = soup.find('a', href=MB_PATTERN)
                uuid = uuid_from_soup(soup, 'artist')
                albums = soup('span', {'class':'mw-headline'})
            except AttributeError:
                pass
            if DEBUG_PRINT: print artist.string, '-', uuid
            data[artist.string] = {'albums':{}, 'uuid':uuid}

            # Loop through all artists' albums
#            for album in [albums[0]]:
            for album in albums:
                try:
                    uuid = None
                    if album('a'):
                        albumurl = album('a')[0]['href']
                        if albumurl.find('action=edit') == -1:
                            soup = BeautifulSoup(urllib2.urlopen(WIKIA_DOMAIN+albumurl).read())
                            uuid = uuid_from_soup(soup, 'release')
                    songs = album.parent
                    while (type(songs) is not Tag) or (songs.name != 'ol' and songs.name != 'ul'):
                        try:
                            songs = songs.nextSibling
                            if type(songs) is Tag and songs.name == 'h2':
                                raise AttributeError
                        except AttributeError:
                            songs = None
                            break
                    if not songs:
                        continue
                    albumtitle = album('a')[0].string if album('a') else "(No Album)"
                    if DEBUG_PRINT: print "\t", albumtitle
                    data[artist.string]['albums'][albumtitle] = {'songs':{}, 'uuid':uuid}

#                    for song in songs('a'):
#                        data['artists'][artist.string]['albums'][albumtitle]['songs'][song.string] = {}
                except AttributeError:
                    pass
#                continue

                # Loop through all songs on album and fetch lyrics
#                for song in [songs('a')[0]]:
                for song in songs('a'):
                    if song['href'].find('action=edit') > -1:
                        continue
                    soup = BeautifulSoup(urllib2.urlopen(WIKIA_DOMAIN+song['href']).read())
#                    uuid = uuid_from_soup(soup, 'recording')
                    uuid = None
                    try:
                        lyricsdiv = soup('div', {'class':'lyricbox'})[0]

                        # Clean up lyrics (remove <div> and crap)
                        # This needs to be fine-tuned
                        for div in lyricsdiv('div'):
                            div.extract()

                        # Get lyrics line by line
                        lyrics = u''
                        for s in lyricsdiv.contents:
                            line = unicode(s)
                            if line == '<br />':
                                lyrics += "\n"
                            elif line == "\n":
                                pass
                            else:
                                lyrics += unescape(line).strip()
                        lyrics = lyrics.replace('<!--','').replace('-->','').strip()

                        if DEBUG_PRINT: print "\t\t", song.string, "-", WIKIA_DOMAIN+song['href']
                        if DEBUG_PRINT: print "\t\t\t", lyrics
                        data[artist.string]['albums'][albumtitle]['songs'][song.string] = {'lyrics':lyrics, 'uuid':uuid}
                    except AttributeError:
                        pass

        # Fetch next page of artists
        nexturl = False
        if nexturl:
            print WIKIA_DOMAIN+nexturl['href']
            soup = BeautifulSoup(urllib2.urlopen(WIKIA_DOMAIN+nexturl['href']).read())
        else:
            break

    f = open(file_out, 'w')
    json.dump(data, f)
    print json.dumps(data)


## Script start
#################

if len(sys.argv) < 3:
    print USAGE
    sys.exit(1)
else:
    if sys.argv[1] == 'scrape':
        print "Starting scape of %s..." % sys.argv[2]
    elif sys.argv[1] == 'import':
        json_file = sys.argv[2]
        print "Importing %s into database '%s'..." % (json_file, DB_NAME)
#        json_to_db(json_file)
    else:
        print USAGE
        sys.exit(1)

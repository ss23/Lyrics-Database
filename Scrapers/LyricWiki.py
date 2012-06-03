import htmlentitydefs, re, urllib2, json, sys
from musicbrainz2.utils import extractUuid
from musicbrainz2.webservice import Query, ArtistFilter, WebServiceError
from bs4 import BeautifulSoup, Tag, Comment
from ScrapeJam import ScrapeJam, unescape, getHtml, cleanLyrics

WIKIA_DOMAIN = 'http://lyrics.wikia.com'
MB_PATTERN = re.compile('^http://musicbrainz.org*')

def uuid_from_soup(soup, type = None):
	uuid_link = soup.find('a', href=MB_PATTERN)
	if uuid_link:
		try:
			return extractUuid(uuid_link['href'], type)
		except ValueError:
			pass # Not a valid UUID for some reason?
	return None

def getAlbums(artist_tuple):
	soup = BeautifulSoup(getHtml(WIKIA_DOMAIN+artist_tuple[1]))
	albums = soup.select('span.mw-headline')
	ret = []
	for album in albums:
		album_url = None
		if album('a'):
			album_name = album('a')[0].string
			album_url = album('a')[0]['href']
		else:
			album_name = None
		if album_url and album_url.find('action=edit') != -1:
			album_url = None
		ret.append((album_name, album_url))
	return ret
	
def getSongs(artist_tuple, album_tuple):
	soup = BeautifulSoup(getHtml(WIKIA_DOMAIN+artist_tuple[1]))
	albums = soup.select('span.mw-headline')
	if not album_tuple[0]: # If album has no name and is in a "Other Songs" category
		for album in albums:
			if not album('a'):
				songs = album.parent
	elif not album_tuple[1]: # If album has a name, but no link to go to
		for album in albums:
			if album('a')[0].string == album_tuple[0]:
				songs = album.parent
	else:
		songs = soup.select('a[href=%s]'%album_tuple[1])[0].parent.parent
	while (type(songs) is not Tag) or (songs.name != 'ol' and songs.name != 'ul'):
		try:
			songs = songs.nextSibling
			if type(songs) is Tag and songs.name == 'h2':
				raise AttributeError
		except AttributeError:
			songs = None
			break
	ret = []
	if songs:
		for song in songs('a'):
			if song['href'].find('action=edit') > -1:
				continue
			ret.append((song.string, song['href']))
	return ret
	
def getLyrics(artist_tuple, album_tuple, song_tuple):
	soup = BeautifulSoup(getHtml(WIKIA_DOMAIN+song_tuple[1]))
	lyricsdiv = soup.select('div.lyricbox')[0]
	if lyricsdiv.select('a[href=/Category:Instrumental]'):
		lyrics = "(Instrumental)"
	else:
		# Remove divs and crap from wiki lyrics box
		for div in lyricsdiv('div'):
			div.extract()
		comments = lyricsdiv.find_all(text=lambda text:isinstance(text, Comment))
		for comment in comments:
			comment.extract()
	return unescape(cleanLyrics(lyricsdiv))

WIKI_URL = 'http://lyrics.wikia.com/index.php?title=Category:Artists_A'
def scrape():
	soup = BeautifulSoup(getHtml(WIKI_URL))
	artists_a = soup.select('div#mw-pages')[0]('a')
	artists = [(artist.string, artist['href']) for artist in artists_a]
	#for i in range(32): artists.pop(0)
	sj = ScrapeJam('lyricwiki.json', 'lyricwiki_errs.log')
	sj.scrape(artists, getAlbums, getSongs, getLyrics)

scrape()

import config, urllib2, re, sys
from bs4 import BeautifulSoup
from ScrapeJam import ScrapeJam, getHtml, cleanLyricList

DARKLYRICS_URL = 'http://www.darklyrics.com/'

def getArtists():
	ret = []
	# Artist pages indexed by start letter
	page_list = [chr(i) for i in range(97,123)] + ['19']
	for page in page_list:
		sys.stdout.write(page)
		sys.stdout.flush()
		soup = BeautifulSoup(getHtml(DARKLYRICS_URL + page + ".html"))
		artists = soup.select('.artists.fl a[href^='+page+'/]')
		ret += [(artist.string.title(), artist['href']) for artist in artists]
		artists = soup.select('.artists.fr a[href^='+page+'/]')
		ret += [(artist.string.title(), artist['href']) for artist in artists]
		# break
	return ret

def getAlbums(artist_tuple):
	soup = BeautifulSoup(getHtml(DARKLYRICS_URL+artist_tuple[1]))
	albums = soup.select('.album h2 strong')
	return [(album.string[1:-1], artist_tuple[1]) for album in albums]
	
def getSongs(artist_tuple, album_tuple):
	soup = BeautifulSoup(getHtml(DARKLYRICS_URL+album_tuple[1]))
	albums = soup.select('.album')
	for album in albums:
		if album.h2.strong.string[1:-1] == album_tuple[0]:
			return [(song.string, song['href'][3:-2]) for song in album.select('a')]
	return None
	
def getLyrics(artist_tuple, album_tuple, song_tuple):
	soup = BeautifulSoup(getHtml(DARKLYRICS_URL+song_tuple[1]))
	songs = soup.select('.lyrics h3')
	for song in songs:
		if song.string[song.string.index(' ')+1:] == song_tuple[0]:
			lyrics = []
			while song.next_sibling.name not in ['h3','div','a']:
				song = song.next_sibling
				lyrics += [song]
			return cleanLyricList(lyrics)
	return None

def scrape():
	print("Fetching DarkLyrics artist list...")
	artists = getArtists()
	print("...Done.\n")
	# albums = getAlbums(artists[2])
	# songs = getSongs(artists[2], albums[4])
	# lyrics = getLyrics(artists[2], albums[4], songs[9])
	# print(lyrics)
	sj = ScrapeJam('darklyrics.json', 'darklyrics_errs.json')
	sj.scrape(artists, getAlbums, getSongs, getLyrics)

scrape()
import config, urllib2, re, sys
from bs4 import BeautifulSoup
from ScrapeJam import ScrapeJam, getHtml, cleanLyricList

def getArtists():
	soup = BeautifulSoup(getHtml('http://www.uta-net.com/user/search_index/name.html'))
	artists = soup.select('.album td a')
	return [(artist.string, 'http://www.uta-net.com/user/search_index/'+artist['href']) for artist in artists]

def getAlbums(artist_tuple):
	soup = BeautifulSoup(getHtml(artist_tuple[1]).decode('shift_jisx0213'), "html.parser")
	albums = soup.select('td.font_base_size_L strong')
	return [(album.string, artist_tuple[1]) for album in albums]
	
def getSongs(artist_tuple, album_tuple):
	soup = BeautifulSoup(getHtml(album_tuple[1]).decode('shift_jisx0213'), "html.parser")
	albums = soup.select('td.font_base_size_L strong')
	for album in albums:
		if album.string == album_tuple[0]:
			songs = album.find_parent("table").find_parent("table").select('.font_base_size a')
			for song in songs:
				subtags = song.select('*')
				for tag in subtags:
					tag.extract()
			return [(song.string, 'http://sp.uta-net.com/search/kashi.php?TID='+song['href'][song['href'].index('ID=')+3:]) for song in songs]
	return []
	
def getLyrics(artist_tuple, album_tuple, song_tuple):
	soup = BeautifulSoup(getHtml(song_tuple[1], False,
		'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'))
	lyrics = soup.select('#kashi_main')[0]
	lyrics.div.extract()
	return cleanLyricList(lyrics.contents)

	songs = soup.select('.lyrics h3')
	for song in songs:
		if song.string[song.string.index(' ')+1:] == song_tuple[0]:
			lyrics = []
			while song.next_sibling.name not in ['h3','div','a']:
				song = song.next_sibling
				lyrics += [song]
			return cleanLyricList(lyrics)
	return ""
	
def scrape():
	artists = getArtists()
	sj = ScrapeJam('utanet.json', 'utanet.error.json')
	sj.scrape(artists, getAlbums, getSongs, getLyrics)

scrape()
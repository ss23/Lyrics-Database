import config, urllib2, re
from bs4 import BeautifulSoup
from ScrapeJam import ScrapeJam, getHtml, cleanLyrics

NIGHTWISH_URL = 'http://nightwish.com/en/releases/lyrics'

def getAlbums(artist_tuple):
	soup = BeautifulSoup(getHtml(artist_tuple[1]))
	albums = soup.select('.sidebar_right_2c a')
	ret = []
	for album in albums:
		try:
			ret.append((album.img['title'], album['href']))
		except Exception as e:
			# This just means its not an album
			pass # PASSU
	return ret
	
def getSongs(artist_tuple, album_tuple):
	soup = BeautifulSoup(getHtml(NIGHTWISH_URL+album_tuple[1]))
	songs = soup.select('.box250 .textsmall li a')
	return [(song.string, song['href']) for song in songs]
	
def getLyrics(artist_tuple, album_tuple, song_tuple):
	soup = BeautifulSoup(getHtml(NIGHTWISH_URL+song_tuple[1]))
	lyricsoup = soup.select('.content_main_2c .text')[0]
	return cleanLyrics(lyricsoup)
	
def scrape():
	sj = ScrapeJam('nightwish.json', 'nightwish_errs.json')
	sj.scrape([('Nightwish',NIGHTWISH_URL)], getAlbums, getSongs, getLyrics)

scrape()

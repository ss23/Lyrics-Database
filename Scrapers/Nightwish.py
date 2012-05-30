import config, urllib2, re, LyricJam
from bs4 import BeautifulSoup

NIGHTWISH_URL = 'http://nightwish.com/en/releases/lyrics'

def scrape():
	try:
		soup = BeautifulSoup(urllib2.urlopen(NIGHTWISH_URL).read())
	except Exception as e: 
		print "Error initilizaing scraper:"
		print e

	# Get albums
	albums = {}
	album_soup = soup.select('.sidebar_right_2c a')

	for album in album_soup:
		try:
			a = re.search(r"a=([0-9]*)", album['href']).group(1)
			albums[album.img['title']] = a
		except Exception as e:
			# This just means its not an album
			pass # PASSU

	for name, id in albums.iteritems():
		# Get those songs!
		i = 1;

		while i < 15:
			try:
				soup =  BeautifulSoup(urllib2.urlopen(NIGHTWISH_URL + '?a=' + str(id) + '&s=' + str(i)).read())
				lyrics = soup.select('.content_main_2c .text')[0].text
				title = soup.select('.content_main_2c .headline3')[0].text

				LyricJam.addLyrics('Nightwish', name, title, lyrics)
			except Exception as e:
				i = 16
				# Make sure that i is high!
			else:
				i += 1	
	
	# Done!		
# Go!
scrape()

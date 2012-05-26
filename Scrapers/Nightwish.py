import config, urllib2
from BeautifulSoup import BeautifulSoup, Tag

NIGHTWISH_URL = 'http://nightwish.com/en/releases/lyrics'

def scrape():
	try:
		soup = BeautifulSoup(urllib2.urlopen(NIGHTWISH_URL).read())
	except Exception as e: 
		print "Error initilizaing scraper:"
		print e

	# Get albums
	albums = []
	album_soup = soup.select('.sidebar_right_2c:first-child a')
	album_regex = re.compile(r"s=[0-9]*")
	for album in album_soup:
		albums.append({'name': album.img['alt'], 'id': album_regex.search(album.['href']))

	# So now we have artists in albums
	for album in albums:
		# Now, we need to get a list of songs, and get each of them
		soup = BeautifulSoup(urllib2.urlopen(NIGHTWISH_URL + '/?a=' album['id'] . + '&s=1')

		for song in songs
			

# Go!
scrape()

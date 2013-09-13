from progressbar import ProgressBar, Bar, ETA, FormatLabel, Percentage
import curses, time, traceback
import htmlentitydefs, re, urllib2, json, sys

SJ_ARTIST = 0
SJ_ALBUM	= 1
SJ_SONG		= 2

def unescape(text): # When sites try to get sneaky: &#76;&#79;&#76;
	def fixup(m):
		text = m.group(0)
		if text[:2] == "&#": # html character reference
			try:
				if text[:3] == "&#x":
					return unichr(int(text[3:-1], 16))
				else:
					return unichr(int(text[2:-1]))
			except ValueError:
				pass
		else: # named entity
			try:
				text = unichr(htmlentitydefs.name2codepoint[text[1:-1]])
			except KeyError:
				pass
		return text # leave as is
	return re.sub("&#?\w+;", fixup, text)

def cleanLyricList(list):
	ret = ''
	for line in list:
		ret += unicode(line).strip()
	ret = re.sub(r'<br[^>]*>', '\n', ret)
	return ret.strip('\n')
	
# Fetch HTML with caching
htmlCache = {}
def getHtml(url, clearCache=False):
	global htmlCache
	if clearCache: htmlCache = {}
	if not url in htmlCache:
		req = urllib2.Request(url)
		req.add_header('User-agent', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)')
		htmlCache[url] = urllib2.urlopen(req).read()
	#print "CACHE: ", [x for x in htmlCache]
	return htmlCache[url]

class ScrapeJam: # Here's your chance, do your dance, at the ScrapeJam

	widgets = [Percentage(), Bar(), FormatLabel(' %(value)d/%(max)d '),
						ETA(), FormatLabel(' (%(elapsed)s)')]
						
	def __init__(self, filepath, errorlog=None):
		self.file = filepath
		self.log = errorlog
		self.win = curses.initscr()
		curses.start_color()
		curses.curs_set(0)
		curses.noecho()
		curses.cbreak()
		self.refresh()
		
	def __del__(self):
		pass
		
	def write(self, file, data):
		f = open(file, 'w')
		json.dump(data, f)
		f.close()
		
	def refresh(self, clear=True):
		if clear:
			self.win.clrtobot()
		self.win.refresh()
		
	def move(self, y, x):
		self.win.move(y,x)
		self.refresh(False)
		
	# @param artists		List of tuples (artist_name, artist_url)
	# @param album_fn		Func(artist_tuple): returns list of tuples (album_name, album_url)
	# @param song_fn		Func(artist_tuple, album_tuple): returns list of tuples (song_name, song_url)
	# @param lyric_fn		Func(artist_tuple, album_tuple, song_tuple): returns lyrics or None
	# TODO: fill in UUIDs
	def scrape(self, artists, album_fn, song_fn, lyric_fn, errorlog=None):
		
		def errorwrap(fn):
			def wrapped(*args, **kwargs):
				try:
					return fn(*args, **kwargs)
				except Exception as e:
					error(e)
					return [] # In the case that error() just logged and continued
			return wrapped
					
		def error(e):
			if self.log:
				# Log the error and continue on your merry way (or explode w/o log file)
				self.errorlist.append({artist[0]: [song[1], traceback.format_exc()] })
			else:
				raise e
			
		album_fn = errorwrap(album_fn)
		song_fn = errorwrap(song_fn)
		lyric_fn = errorwrap(lyric_fn)
		i = [0,0,0] # Incrementors for artists, albums, and songs
		done = [0,0,0] # Counter for completed scrapes
		data = {}
		self.errorlist = []
		try:
			self.artists_pbar = ProgressBar(widgets=[' Artists:']+self.widgets, maxval=len(artists)).start()
			for artist in artists:
				albums = album_fn(artist)
				if len(albums) == 0: continue
				i[SJ_ALBUM] = 0
				data[artist[0]] = {'albums':{}, 'uuid':None}
				self.albums_pbar = ProgressBar(widgets=[' Albums: ']+self.widgets, maxval=len(albums)).start()
				for album in albums:
					songs = song_fn(artist, album)
					if len(songs) == 0: continue
					i[SJ_SONG] = 0
					data[artist[0]]['albums'][album[0]] = {'songs':{}, 'uuid':None}
					self.songs_pbar = ProgressBar(widgets=[' Songs:  ']+self.widgets, maxval=len(songs)).start()
					for song in songs:
						lyrics = lyric_fn(artist, album, song)
						if not lyrics: continue
						data[artist[0]]['albums'][album[0]]['songs'][song[0]] = {'lyrics':lyrics, 'uuid':None}
						i[SJ_SONG] += 1
						done[SJ_SONG] += 1
						self.drawProgress((artist[0],album[0],song[0]), i, done)
					i[SJ_ALBUM] += 1 # Completed an album
					done[SJ_ALBUM] += 1
				i[SJ_ARTIST] += 1 # Completed an artist
				done[SJ_ARTIST] += 1
				htmlCache = {} # Reset HTML cache after each artist
		except Exception:
			curses.nocbreak()
			curses.echo()
			curses.endwin()
			traceback.print_exc()
			print "Ended on (%s) (%s) (%s)" % (artist[0], album[0], song[0])
		except KeyboardInterrupt:
			pass
		finally: # Must be run to restore terminal's state to normal
			curses.nocbreak()
			curses.echo()
			curses.endwin()
			self.write(self.file, data)
			if self.log and len(self.errorlist) != 0:
				self.write(self.log, self.errorlist)

	def drawProgress(self, names, values, done):
		self.move(0,0)
		self.artists_pbar.update(values[0])
		self.move(1,0)
		self.albums_pbar.update(values[1])
		self.move(2,0)
		self.songs_pbar.update(values[2])
		self.win.addstr(4, 0, " Artist: "+names[0].encode('utf_8'))
		self.refresh()
		self.win.addstr(5, 0, " Album:  "+(names[1] if names[1] else "N/A").encode('utf_8'))
		self.refresh()
		self.win.addstr(6, 0, " Song:   "+names[2].encode('utf_8'))
		self.refresh()
		self.win.addstr(8, 0, " COMPLETED")
		self.win.addstr(9, 0, " Artists: %d  Albums: %d  Songs: %d" % tuple(done))
		if self.log:
			self.win.addstr(10, 0, " Fatal errors: %d" % len(self.errorlist))
		self.refresh()
		self.move(2,0)

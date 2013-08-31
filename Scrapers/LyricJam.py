from config import *
import sys, simplejson as json
import MySQLdb as mdb

USAGE = '''
Usage: LyricJam.py {scrape|import} arg
	Examples:
		import file.json
			Import file.json into the lyric database
'''

class LyricJam:
	
	def __init__(self):
		self.con = mdb.connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, charset='utf8')
		self.cur = self.con.cursor()
		
	# Really needs to be updated to use UUIDs
	def addLyrics(self, artist, album, title, lyrics):
		print "Adding new lyrics " + title + " - " + artist + " [" + album + "]"
		self.cur = self.con.cursor()

		self.cur.execute("SELECT `id` FROM `artists` WHERE `name` LIKE %s", (artist))
		if (self.cur.rowcount < 1):
			# Insert a new row
			self.cur.execute("INSERT INTO `artists` (`name`) VALUES (%s)", (artist))
			artist_id = self.cur.lastrowid
		else:
			artist_id = self.cur.fetchone()[0]

		self.cur.execute("SELECT `id` FROM `albums` WHERE `name` LIKE %s", (album))
		if (self.cur.rowcount < 1):
			# New album!
			self.cur.execute("INSERT INTO `albums` (`name`) VALUES (%s)", (album))
			album_id = self.cur.lastrowid
		else:
			album_id = self.cur.fetchone()[0]

		# Insert song
		self.cur.execute("SELECT `song_id` FROM `albums_songs` WHERE `album_id` = %s", (album_id))
		if (self.cur.rowcount > 0):
			# We have at least one song on this album
			self.cur.execute("SELECT `id` FROM `songs` WHERE `id` = %s AND `name` LIKE %s", (cur.fetchone()[0], title))
			if (self.cur.rowcount > 0):
				# Looks like this song is a duplicate!
				return
			
		self.cur.execute("INSERT INTO `songs` (`name`, `lyrics`) VALUES (%s, %s)", (title, lyrics))
		song_id = self.cur.lastrowid

		self.cur.execute("INSERT INTO `albums_songs` (`song_id`, `album_id`) VALUES (%s, %s)", (song_id, album_id))
		self.cur.execute("INSERT INTO `artists_songs` (`song_id`, `artist_id`) VALUES (%s, %s)", (song_id, artist_id))

	# Import json file
	def import_json(self, file):
		jsonstr = open(file, 'r').read()
		data = json.loads(jsonstr)
		for artist in data:
			try:
				artist_uuid = data[artist]['uuid']
				self.cur.execute("INSERT INTO artists (`name`, `uuid`) VALUES (%s, %s)", (artist, artist_uuid))
				artist_id = self.cur.lastrowid
				print "%d - %s - %s" % (artist_id, artist, artist_uuid)
				for album in data[artist]['albums']:
					if album != "null":
						album_uuid = data[artist]['albums'][album]['uuid']
						self.cur.execute("INSERT INTO albums (`name`, `uuid`) VALUES (%s, %s)", (album, album_uuid))
						album_id = self.cur.lastrowid
						print "\t%d - %s - %s" % (album_id, album, album_uuid)
					for song in data[artist]['albums'][album]['songs']:
						lyrics = data[artist]['albums'][album]['songs'][song]['lyrics']
						song_uuid = data[artist]['albums'][album]['songs'][song]['uuid']
						self.cur.execute("INSERT INTO songs (`name`, `lyrics`, `uuid`) VALUES (%s, %s, %s)", (song, lyrics, song_uuid))
						song_id = self.cur.lastrowid
						print "\t\t%d - %s - %s" % (song_id, song, song_uuid)
						if album != "null":
							self.cur.execute("INSERT INTO albums_songs (`song_id`, `album_id`) VALUES (%s, %s)", (song_id, album_id))
						self.cur.execute("INSERT INTO artists_songs (`song_id`, `artist_id`) VALUES (%s, %s)", (song_id, artist_id))
			except mdb.Error, e:
				# Print the failed SQL before the vague error message
				print cur._last_executed
				raise
	
	def close(self):
		self.con.commit()
		self.cur
		self.con.close()


if __name__ == "__main__":
	if len(sys.argv) < 3:
		print USAGE
		sys.exit(1)
	else:
		if sys.argv[1] == 'import':
			json_file = sys.argv[2]
			print "Importing %s into database '%s'..." % (json_file, DB_NAME)
			lj = LyricJam()
			lj.import_json(json_file)
			lj.close() # Commit DB transaction
		else:
			print USAGE
			sys.exit(1)

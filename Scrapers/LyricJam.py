import config
import MySQLdb as mdb

# Really needs to be updated to use UUIDs
# Also needs to not close connection / open it every time etc
def addLyrics(artist, album, title, lyrics):
	print "Adding new lyrics " + title + " - " + artist + " [" + album + "]"
	con = mdb.connect(config.DB_HOST, config.DB_USER, config.DB_PASS, config.DB_NAME)
	cur = con.cursor()

	cur.execute("SELECT `id` FROM `artists` WHERE `name` LIKE %s", (artist))
	if (cur.rowcount < 1):
		# Insert a new row
		cur.execute("INSERT INTO `artists` (`name`) VALUES (%s)", (artist))
		artist_id = cur.lastrowid
	else:
		artist_id = cur.fetchone()[0]

	cur.execute("SELECT `id` FROM `albums` WHERE `name` LIKE %s", (album))
	if (cur.rowcount < 1):
		# New album!
		cur.execute("INSERT INTO `albums` (`name`) VALUES (%s)", (album))
		album_id = cur.lastrowid
	else:
		album_id = cur.fetchone()[0]

	# Insert song
	cur.execute("SELECT `song_id` FROM `albums_songs` WHERE `album_id` = %s", (album_id))
	if (cur.rowcount > 0):
		# We have at least one song on this album
		cur.execute("SELECT `id` FROM `songs` WHERE `id` = %s AND `name` LIKE %s", (cur.fetchone()[0], title))
		if (cur.rowcount > 0):
			# Looks like this song is a duplicate!
			return
		
	cur.execute("INSERT INTO `songs` (`name`, `lyrics`) VALUES (%s, %s)", (title, lyrics))
	song_id = cur.lastrowid

	cur.execute("INSERT INTO `albums_songs` (`song_id`, `album_id`) VALUES (%s, %s)", (song_id, album_id))
	cur.execute("INSERT INTO `artists_songs` (`song_id`, `artist_id`) VALUES (%s, %s)", (song_id, artist_id))

	con.commit()
	cur.close()
	con.close()

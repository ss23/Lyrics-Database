<?php
App::uses('AppModel', 'Model');
App::uses('GearmanQueue', 'Gearman.Client');
/**
 * Song Model
 *
 * @property Album $Album
 * @property Artist $Artist
 */
class Song extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lyrics' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Album' => array(
			'className' => 'Album',
			'joinTable' => 'albums_songs',
			'foreignKey' => 'song_id',
			'associationForeignKey' => 'album_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Artist' => array(
			'className' => 'Artist',
			'joinTable' => 'artists_songs',
			'foreignKey' => 'song_id',
			'associationForeignKey' => 'artist_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	public function findByArtist($songName, $artistName, $options = array()){
		$defaults = array(
				'conditions' => array(
					'Song.Name' => $songName,
					'Artist.Name' => $artistName,
				),
				'joins' => array(
					array(
						'table' => 'artists_songs',
						'alias' => 'ArtistSong',
						'type' => 'inner',
						'conditions' => array('ArtistSong.song_id = Song.id'),
					),
					array(
						'table' => 'artists',
						'alias' => 'Artist',
						'type' => 'inner',
						'conditions' => array(
							'Artist.id = ArtistSong.artist_id',
						),
					),
				),
			);
		
		return $this->find('first', array_merge($defaults, $options));
	}

	public function getHot($limit = 50, $cached = true) {
		if (!is_int($limit)) {
			throw new Exception("Invalid limit");
		}

		if ($limit > 100) {
			throw new Exception("We were asked to get more entries than we could");
		}
		
		if ($cached) {
			$songs = Cache::read('hot_songs_'.$limit, '_hourly_');
			if ($songs !== false)
				return $songs;
			GearmanQueue::execute('getHotSongs', $limit);
			$songs = Cache::read('hot_songs_'.$limit, 'longterm');
			if ($songs !== false)
				return $songs;
			// Empty page until gearman proceses the above task
			return array();
		}

		$apidata = LastFM\Geo::getTopTracks("united states", null, 500);
		// 500 is a little hefty, but it should be okay for now

		$songs = array();
		foreach ($apidata as $song) {
			if (count($songs) >= $limit) {
				break;
			}
			// Find the artist first
			$s = $this->findByArtist($song->getName(), $song->getArtist()->getName());

			if ($s) {
				$songs[] = array('Song' => $s, 'Art' => $song->getImage(LastFM\Media::IMAGE_EXTRALARGE));
			}
		}

		Cache::write('hot_songs_'.$limit, $songs, '_hourly_');
		Cache::write('hot_songs_'.$limit, $songs, 'longterm');
		return $songs;
	}
	
}

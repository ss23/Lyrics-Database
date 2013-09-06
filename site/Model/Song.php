<?php
App::uses('AppModel', 'Model');
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

	public function getHot($limit = 50) {
		if (!is_int($limit)) {
			throw new Exception("Invalid limit");
		}

		if ($limit > 100) {
			throw new Exception("We were asked to get more entries than we could");
		}

		if (!Configure::read('lastfmkey')) {
			throw new Exception("No Last.FM key configured");
		}

		$json = Cache::read('lastfm_hot_songs', '_hourly_');
		if (!$json) {
			$json = json_decode(file_get_contents('http://ws.audioscrobbler.com/2.0/?method=chart.gettoptracks&format=json&limit=500&api_key=' . Configure::read('lastfmkey')), true);
			// 500 is a little hefty, but it should be okay for now
			$json = $json['tracks']['track'];
			Cache::write('lastfm_hot_songs', $json, '_hourly_');
		}

		$songs = array();
		foreach ($json as $song) {
			if (count($songs) >= $limit) {
				break;
			}
			// Find the artist first
			$s = $this->find('first', array(
				'conditions' => array(
					'Song.Name' => $song['name'],
					'Artist.Name' => $song['artist']['name'],
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
			));
			if ($s) {
				$songs[] = array('Song' => $s, 'Art' => $song['image'][3]['#text']);
			}
		}

		return $songs;
	}
}

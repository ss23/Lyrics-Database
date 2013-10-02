<?php
App::uses('AppModel', 'Model');
/**
 * Artist Model
 *
 * @property Song $Song
 */
class Artist extends AppModel {
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Song' => array(
			'className' => 'Song',
			'joinTable' => 'artists_songs',
			'foreignKey' => 'artist_id',
			'associationForeignKey' => 'song_id',
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
	
	public function getHot($limit = 50, $cached = true) {
		if (!is_int($limit)) {
			throw new Exception("Invalid limit");
		}

		if ($limit > 100) {
			throw new Exception("We were asked to get more entries than we could");
		}
		
		if ($cached) {
			$artists = Cache::read('hot_artists_'.$limit, '_hourly_');
			if ($artists !== false)
				return $artists;
		}

		$apidata = LastFM\Geo::getTopArtists("united states", 500);
		// 500 is a little hefty, but it should be okay for now
		
		$artists = array();
		foreach ($apidata as $artist) {
			if (count($artists) >= $limit) {
				break; // We have enough
			}
			$this->recursive = -1;
			$a = $this->findByName($artist->getName());
			if ($a) {
				$artists[] = array(
						'Artist' => $a['Artist'],
						'Song' => array(),
						'Art' => $artist->getImage(),
				);
			}
			// TODO: add a more fuzzy fallback or something
		}
		// Get top tracks for each artist
		$this->Song->recursive = 2;
		foreach ($artists as &$artist){
			$tracks = LastFM\Artist::getTopTracks($artist['Artist']['name']);
			foreach ($tracks as $track) {
				$song = $this->Song->findByArtist($track->getName(), $artist['Artist']['name']);
				if ($song)
					$artist['Song'][] = $song;
			}
		}

		Cache::write('hot_artists_'.$limit, $artists, '_hourly_');
		return $artists;
	}

}

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

		$json = Cache::read('lastfm_hot_artists', '_hourly_');
		if (!$json) {
			$json = json_decode(file_get_contents('http://ws.audioscrobbler.com/2.0/?method=chart.gettopartists&format=json&limit=500&api_key=' . Configure::read('lastfmkey')), true);
			// 500 is a little hefty, but it should be okay for now
			$json = $json['artists']['artist'];
			Cache::write('lastfm_hot_artists', $json, '_hourly_');
		}

		$artists = array();
		foreach ($json as $artist) {
			if (count($artists) >= $limit) {
				break; // We have enough
			}
			$a = $this->findByName($artist['name']);
			if ($a) {
				$artists[] = array('Artist' => $a, 'Art' => $artist['image'][4]['#text']);
			}
			// TODO: add a more fuzzy fallback or something
		}

		return $artists;
	}

}

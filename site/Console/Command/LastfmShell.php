<?php

class LastfmShell extends AppShell {
	
	public $uses = array('Album','Artist','Song');
	
	public function sync() {
		$artist_name = (count($this->args) > 0) ? $this->args[0] : null;
		// TODO: Utilize all musicbrainz uuids in json to sync and update our db
		$this->out('<info>Syncing with Last.fm for album art and Musicbrainz UUIDs ...</info>');
		// If artist argument supplied, sync only albums for that artist, else sync all albums
		// Fetch albums with no art, no recursion for speed and memory reasons
		$this->Album->recursive = -1;
		if ($artist_name) {
			$this->Artist->recursive = 2;
			$artist = $this->Artist->findByName($artist_name);
			if (!$artist) {
				throw new NotFoundException(__('Invalid artist'));
			}
			$album_ids = array_unique(Hash::extract($artist, 'Song.{n}.Album.{n}.id'));
			$albums = $this->Album->find('all', array(
					'fields' => array('DISTINCT id', 'name', 'slug', 'art'),
					'conditions' => array(
							'id' => $album_ids,
							'art' => '',
						)
				)
			);
		} else {
			$albums = $this->Album->find('all', array(
					'conditions' => array('art' => '')
			));
		}
		
		$this->Album->recursive = 2;
		foreach ($albums as $album){
// 			if (!empty($album['Album']['uuid']))
// 				$this->out($album['Album']['uuid']);
			$a = $this->Album->findById($album['Album']['id']);
			if (count($a['Song']) > 0) {
				$json = json_decode(file_get_contents('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&artist='.urlencode($a['Song'][0]['Artist'][0]['name']).'&album='.urlencode($a['Album']['name']).'&format=json&api_key=' . Configure::read('lastfmkey')), true);
				if (isset($json['error'])) {
					$this->out('<error>Last.fm error "'.$json['message'].'": '.$a['Song'][0]['Artist'][0]['name'].' - '.$a['Album']['name'].'</error>');
				} else if (empty($json['album']['image'][4]['#text'])){
					$this->out('<error>No Last.fm album art: '.$a['Song'][0]['Artist'][0]['name'].' - '.$a['Album']['name'].'</error>');
				} else {
					$this->out(print_r($json, true));
					$a['Album']['art'] = $json['album']['image'][4]['#text'];
					$this->Album->save($a['Album']);
					$this->out($a['Album']['name']);
				}
			} else {
				$this->out('<error>No songs in album: '.$a['Album']['name'].'</error>');
			}
		}
	}

}

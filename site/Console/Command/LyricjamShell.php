<?php

App::uses('SlugLib', 'LyricJam');

class LyricjamShell extends AppShell {
	
	public $uses = array('Album','Artist','Song');
	
	public $helpers = array('Slug');

// 	public function main() {
// 		$this->out('Sup bro.');
// 	}
	
	public function slugify() {
		$purge = false;
		if (count($this->args) > 0)
			$purge = $this->args[0] == "purge";
		$this->slugifyModel("Artist", $purge);
		$this->slugifyModel("Album", $purge);
		$this->slugifyModel("Song", $purge);
	}
	
	private function slugifyModel($model, $purge=false){
		$this->out('<info>Generating slugs for all '.$model.'s ...</info>');
		if ($purge) {
			$this->{$model}->updateAll(array($model.'.slug'=>"''"));
		}
		$this->{$model}->recursive = -1;
		$data = $this->{$model}->find('all');
		foreach ($data as $item) {
			if (empty($item[$model]['slug'])) {
				$slug = SlugLib::slugify($item[$model]['name']);
				$duplicate = $this->{$model}->findBySlug($slug);
				$i = 1;
				while ($duplicate) {
					$slug = SlugLib::slugify($i++." ".$item[$model]['name']);
					$duplicate = $this->{$model}->findBySlug($slug);
				}
				$item[$model]['slug'] = $slug;
				$this->{$model}->save($item[$model]);
			}
		}
		$this->out("Done.");
	}

}

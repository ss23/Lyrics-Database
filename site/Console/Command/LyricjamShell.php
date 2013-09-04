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

	public function generateSitemap() {
		// There has to be some way to get this automatically, but...
		$pages = array();
		$pages[] = array('loc' => '/', 'changefreq' => 'hourly', 'priority' => '1.0');
		foreach (array('about', 'apidocs') as $page) { // Static pages
			$pages[] = array('location' => '/pages/' . $page, 'changefreq' => 'weekly', 'priority' => '0.5');
		}

		// Next, add every static page for artists/songs/albums
		foreach (array('artists', 'songs', 'albums') as $page) {
			// Perhaps should add a new page here for every pagination page
			$pages[] = array('location' => '/' . $page, 'changefreq' => 'weekly', 'priority' => '0.2');
			// Do we still have "hot" artists etc? I think it's a nice feature, but it might as well
			// replace the entire index controller eventually
		}

		// Generate the XML
		file_put_contents('/tmp/lj-sitemap.xml', $this->generateXML($pages));
		$this->out("Done.");
	}

	protected function generateXML($pages) {
		$xml = <<<XML
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
XML;
		foreach ($pages as $page) {
			$xml .= "<url>";
			foreach ($page as $key => $value) {
				$xml .= "<" . $key . ">" . $value . "</" . $key . ">";
			}
			$xml .= "</url>";
		}
		$xml .= "</urlset>";
		return $xml;
	}

}

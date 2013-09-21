<div class="songs">

	<?php
		$this->MicrodataHtml->addCrumb($song['Artist'][0]['name'], array('controller' => 'artists', 'action' => 'view', 'artist' => $song['Artist'][0]['slug']));
		$this->MicrodataHtml->addCrumb($song['Album'][0]['name'], array('controller' => 'albums', 'action' => 'view', 'album' => $song['Album'][0]['slug'], 'artist' => $song['Artist'][0]['slug']));
		$this->MicrodataHtml->addCrumb($song['Song']['name']);
		echo $this->element("breadcrumbs");
	?>
	
	<div id="google_translate_element" class="pull-right"></div>
	
	<div id="song-album"><?php echo $this->Html->image($this->Thumbnail->get($song['Album'][0], 'small')) ?></div>
	
	<h2><?php echo h($song['Song']['name']); ?></h2>
	<div class="lyrics">
	<?php
		$lyric_html = str_replace("\n\n", "</p><p>&nbsp;</p><p>", h($song['Song']['lyrics']));
		echo '<p>'.str_replace("\n", "</p><p>", $lyric_html).'</p>';
	?>
	</div>
	
	<script type="text/javascript">
	function googleTranslateElementInit() {
	  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: '<?php echo Configure::read('google-analytics') ?>'}, 'google_translate_element');
	}
	</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>

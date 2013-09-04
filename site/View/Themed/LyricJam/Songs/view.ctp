<div class="songs">

	<?php
		$this->MicrodataHtml->addCrumb($song['Artist'][0]['name'], array('controller' => 'artists', 'action' => 'view', 'artist' => $song['Artist'][0]['slug']));
		$this->MicrodataHtml->addCrumb($song['Album'][0]['name'], array('controller' => 'albums', 'action' => 'view', 'album' => $song['Album'][0]['slug'], 'artist' => $song['Artist'][0]['slug']));
		$this->MicrodataHtml->addCrumb($song['Song']['name']);
		echo $this->element("breadcrumbs");
	?>
	
	<div id="google_translate_element" class="pull-right"></div>
	
	<h2><?php echo h($song['Song']['name']); ?></h2>
	<?php echo nl2br(h($song['Song']['lyrics'])); ?>
	
	<script type="text/javascript">
	function googleTranslateElementInit() {
	  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: '<?php echo Configure::read('google-analytics') ?>'}, 'google_translate_element');
	}
	</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>

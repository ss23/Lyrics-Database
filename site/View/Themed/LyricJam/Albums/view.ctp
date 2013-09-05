<div class="songs">

	<?php
		$artist = $album['Song'][0]['Artist'][0];
		$this->MicrodataHtml->addCrumb($artist['name'], array('controller' => 'artists', 'action' => 'view', 'artist' => $artist['slug']));
		$this->MicrodataHtml->addCrumb($album['Album']['name']);
		echo $this->element("breadcrumbs");
	?>

	<h2><?php echo h($album['Album']['name']); ?></h2>

	<?php if (!empty($album['Song'])):?>
		<div class="list-group col-md-5">
		<?php
			foreach ($album['Song'] as $song) {
				echo $this->Html->link($song['name'],
						array('controller'=>'songs', 'action' => 'view', 'song' => $song['slug'], 'album' => $album['Album']['slug'], 'artist' => $artist['slug']),
						array('class'=>'list-group-item')
				);
			}
		?>
		</div>
	<?php endif; ?>

</div>

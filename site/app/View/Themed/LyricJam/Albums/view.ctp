<div class="albums">

	<?php
		$artist = $album['Song'][0]['Artist'][0];
		$this->Html->addCrumb($artist['name'], array('controller' => 'artists', 'action' => 'view', 'id' => $artist['id'], 'slug' => $this->Slug->slugify($artist['name'])));
		$this->Html->addCrumb($album['Album']['name']);
		echo $this->Html->getCrumbs(' > ', __('Home'));
	?>

	<h2><?php echo h($album['Album']['name']); ?></h2>

	<?php if (!empty($album['Song'])):?>
		<?php
		$i = 0;
		foreach ($album['Song'] as $song): ?>
			<div>
			<?php echo $this->Html->link($song['name'], array('controller' => 'songs', 'action' => 'view', 'id' => $song['id'], 'slug' => $this->Slug->slugify($song['name']))); ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

</div>
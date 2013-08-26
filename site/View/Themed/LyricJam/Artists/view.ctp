<div class="artists">

	<?php
		$this->Html->addCrumb($artist);
		echo $this->element("breadcrumbs");
	?>

	<h2><?php echo h($artist); ?></h2>

	<?php
		if (!empty($albums))
			foreach ($albums as $album): ?>
				<div>
					<?php echo $this->Html->link($album['Album']['name'], array('controller' => 'albums', 'action' => 'view', 'id' => $album['Album']['id'], 'slug' => $this->Slug->slugify($album['Album']['name']))); ?>
					<span class="song-count">
						<?php echo count($album['Song']); ?> <?php echo __('Songs'); ?>
					</span>
				</div>
			<?php endforeach; ?>

</div>



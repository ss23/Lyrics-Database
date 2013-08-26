<div class="songs">

	<?php
		$this->Html->addCrumb($song['Artist'][0]['name'], array('controller' => 'artists', 'action' => 'view', 'id' => $song['Artist'][0]['id'], 'slug' => $this->Slug->slugify($song['Artist'][0]['name'])));
		$this->Html->addCrumb($song['Album'][0]['name'], array('controller' => 'albums', 'action' => 'view', 'id' => $song['Album'][0]['id'], 'slug' => $this->Slug->slugify($song['Album'][0]['name'])));
		$this->Html->addCrumb($song['Song']['name']);
		echo $this->element("breadcrumbs");
	?>
	
	<h2><?php echo h($song['Song']['name']); ?></h2>
	<?php echo nl2br(h($song['Song']['lyrics'])); ?>
	
</div>

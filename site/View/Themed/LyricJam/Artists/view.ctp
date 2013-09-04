<div class="artists">

	<?php
		$this->Html->addCrumb($artist['Artist']['name']);
		echo $this->element("breadcrumbs");
	?>

	<h2><?php echo h($artist['Artist']['name']); ?></h2>

	<div class="list-group col-md-5">
	<?php
		foreach ($albums as $album) {
			echo $this->Html->link(h($album['Album']['name']).'<span class="badge pull-right">'.count($album['Song']).'</span>',
					array('controller'=>'albums', 'action' => 'view', 'album' => $album['Album']['slug'], 'artist' => $artist['Artist']['slug']),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
</div>



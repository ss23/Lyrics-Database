<div class="artists">

	<?php
		$this->Html->addCrumb($artist);
		echo $this->element("breadcrumbs");
	?>

	<h2><?php echo h($artist); ?></h2>

	<div class="list-group col-md-5">
	<?php
		foreach ($albums as $album) {
			echo $this->Html->link(h($album['Album']['name']).'<span class="badge pull-right">'.count($album['Song']).'</span>',
					array('controller'=>'albums', 'action' => 'view', 'id' => $album['Album']['id'], 'slug' => $this->Slug->slugify($album['Album']['name'])),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
</div>



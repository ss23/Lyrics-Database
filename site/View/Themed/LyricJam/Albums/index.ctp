<div class="albums">

	<?php echo $this->element('pagination') ?>

	<h2><?php echo __('Albums'); ?></h2>

	<p><?php
		$alt = ($this->Paginator->sortDir() == 'asc') ? "" : "-alt";
		echo $this->Paginator->sort('name', 'Name <span class="glyphicon glyphicon-sort-by-alphabet'.$alt.'"></span>', array('escape'=>false, 'class'=>'btn btn-lg'));
	?></p>
	
	<div class="list-group col-md-5">
	<?php
		foreach ($albums as $album) {
			echo $this->Html->link(h($album['Album']['name']).'<span class="badge pull-right">'.count($album['Song']).'</span>',
					array('action' => 'view', 'id' => $album['Album']['id'], 'slug' => $this->Slug->slugify($album['Album']['name'])),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
	<?php echo $this->element('pagination') ?>
	
</div>

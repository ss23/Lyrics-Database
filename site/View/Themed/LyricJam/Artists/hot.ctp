<div class="artists">

	<?php echo $this->element('pagination') ?>

	<h2><?php echo __('Artists'); ?></h2>

	<p><?php
		$alt = ($this->Paginator->sortDir() == 'asc') ? "" : "-alt";
		echo $this->Paginator->sort('name', 'Name <span class="glyphicon glyphicon-sort-by-alphabet'.$alt.'"></span>', array('escape'=>false, 'class'=>'btn btn-lg'));
	?></p>
	
	<div class="list-group col-md-5">
	<?php
		foreach ($artists as $artist) {
			echo $this->Html->link(h($artist['Artist']['name']).'<span class="badge pull-right">'.count($artist['Song']).'</span>',
					array('action' => 'view', 'id' => $artist['Artist']['id'], 'slug' => $this->Slug->slugify($artist['Artist']['name'])),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
	
	<?php echo $this->element('pagination') ?>
	
</div>
<div class="songs">

	<?php echo $this->element('pagination') ?>
	
	<h2><?php echo __('Songs'); ?></h2>

	<p><?php
		$alt = ($this->Paginator->sortDir() == 'asc') ? "" : "-alt";
		echo $this->Paginator->sort('name', 'Name <span class="glyphicon glyphicon-sort-by-alphabet'.$alt.'"></span>', array('escape'=>false, 'class'=>'btn btn-lg'));
	?></p>
	
	<div class="list-group col-md-5">
	<?php
		foreach ($songs as $song) {
			echo $this->Html->link(h($song['Song']['name']).'<span class="pull-right">'.$song['Artist'][0]['name'].'</span>',
					array('action' => 'view', 'song' => $song['Song']['slug'], 'album' => $song['Album'][0]['slug'], 'artist' => $song['Artist'][0]['slug']),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
	
	<?php echo $this->element('pagination') ?>
	
</div>
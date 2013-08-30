<div class="artists">
	<h2><?php echo __('Artists');?></h2>

	<p><?php echo $this->Paginator->sort('name');?></p>
	
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
	<?php
		if ($this->Paginator->hasPage(2)) {
			echo '<ul class="pagination pagination-lg col-md-12">';
			echo $this->Paginator->prev('&laquo; Prev', array('tag'=>'li', 'escape'=>false), null, array('tag'=>'li', 'escape'=>false, 'class' => 'disabled', 'disabledTag'=>'a'));
			echo $this->Paginator->numbers(array('tag'=>'li', 'separator' => '', 'currentTag'=>'a', 'currentClass'=>'active'));
			echo $this->Paginator->next('Next &raquo;', array('tag'=>'li', 'escape'=>false), null, array('tag'=>'li', 'escape'=>false, 'class' => 'disabled', 'disabledTag'=>'a'));
			echo '</ul>';
		}
	?>
</div>
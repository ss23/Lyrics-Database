<?php 
$start = (isset($this->passedArgs[0])) ? $this->passedArgs[0] : null;
?>

<div class="artists">

	<ul class="letter-list nav nav-pills">
	<?php 
		// Assciated array for index letters: ('a'=>'a', ... '#'=>'0-9')
		$letters = array_merge(array_combine(range('a','z'),range('a','z')), array("#"=>"0-9"));
		foreach ($letters as $letter => $letteruri){
			$class = ($letteruri == $start) ? "active" : "";
			echo '<li class="'.$class.'">'. $this->Html->link($letter, array('start' => $letteruri)) ."</li>";
		}
	?>
	</ul>

	<?php
		if ($start)
			$this->Paginator->options(array('url' => array('start' => $this->passedArgs[0])));
		echo $this->element('pagination');
	?>

	<h2><?php echo __('Artists'); ?> <span class="glyphicon glyphicon-sort-by-alphabet"></span></h2>
	
	<div class="list-group col-md-5">
	<?php
		foreach ($artists as $artist) {
			echo $this->Html->link(h($artist['Artist']['name']).'<span class="badge pull-right">'.count($artist['Song']).'</span>',
					array('action' => 'view', 'artist' => $artist['Artist']['slug']),
					array('escape'=>false, 'class'=>'list-group-item')
			);
		}
	?>
	</div>
	
	<?php echo $this->element('pagination') ?>
	
</div>
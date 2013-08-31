<div class="artists">

	<h2><?php echo __('Hot Artists'); ?></h2>

	<div class="list-group col-md-2">
	<?php
		foreach ($artists as $artist) {
			$html = $this->Html->image($artist['Art'], array('alt' => $artist['Artist']['Artist']['name']));
			$html .= '<div class="caption text-center">' . h($artist['Artist']['Artist']['name']) . '</div>';
			echo $this->Html->link($html,
					array('action' => 'view', 'id' => $artist['Artist']['Artist']['id'], 'slug' => $this->Slug->slugify($artist['Artist']['Artist']['name'])),
					array('escape'=>false, 'class'=>'list-group-item thumbnail')
			);
		}
	?>
	</div>
	
</div>

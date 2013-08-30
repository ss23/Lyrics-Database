<h2>Search for <span class="text-success"><?php echo $query ?></span></h2>

<?php echo $this->element('pagination') ?>

<div class="list-group col-md-4">
	<?php
		foreach ($artists as $artist) {
			echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> '.str_ireplace(h($query), "<strong>".h($query)."</strong>", h($artist['Artist']['name'])).'<span class="badge pull-right">'.count($artist['Song']).'</span>',
					array('controller'=>'artists', 'action' => 'view', 'id' => $artist['Artist']['id'], 'slug' => $this->Slug->slugify($artist['Artist']['name'])),
					array(
							'escape'=>false,
							'class'=>'list-group-item',
					)
			);
		}
		foreach ($songs as $song) {
			echo $this->Html->link('<span class="glyphicon glyphicon-music"></span> '.str_ireplace(h($query), "<strong>".h($query)."</strong>", h($song['Song']['name'])),
					array('controller'=>'songs', 'action' => 'view', 'id' => $song['Song']['id'], 'slug' => $this->Slug->slugify($song['Song']['name'])),
					array(
						'escape'=>false,
						'class'=>'list-group-item',
						'data-toggle'=>'tooltip',
						'data-placement'=>'right',
						'data-html'=>'true',
						'data-original-title'=>str_ireplace(h($query), '<span class=&quot;match-lyric&quot;>'.h($query).'</span>', h($song['Song']['lyrics'])),
						'data-container'=>'body',
					)
			);
		}
	?>
</div>

<?php echo $this->element('pagination') ?>

<h2>Search for <span class="text-success"><?php echo $query ?></span></h2>

<?php echo $this->element('pagination') ?>

<div class="list-group col-md-4">
	<?php
		foreach ($artists as $artist) {
			echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> '.str_ireplace(h($query), "<strong>".h($query)."</strong>", h($artist['Artist']['name'])).'<span class="badge pull-right">'.count($artist['Song']).'</span>',
				array('controller'=>'artists', 'action' => 'view', 'artist' => $artist['Artist']['slug']),
				array(
						'escape'=>false,
						'class'=>'list-group-item',
				)
			);
		}
		foreach ($albums as $album) {
			// This doesn't always work, @ hack to 'fix' temporarily
			echo @$this->Html->link('<span class="glyphicon glyphicon-folder-open"></span>' . str_ireplace(h($query), "<strong>".h($query)."</strong>", h($album['Album']['name'])),
				array(
					'controller'=>'albums',
					'action' => 'view',
					'artist' => $album['Song'][0]['Artist'][0]['slug'],
					'album' => $album['Album']['slug'],
				), array(
					'escape'=>false,
					'class'=>'list-group-item',
				)
			);
		}
		foreach ($songs as $song) {
			echo $this->Html->link('<span class="glyphicon glyphicon-music"></span> '.str_ireplace(h($query), "<strong>".h($query)."</strong>", h($song['Song']['name'])),
				array(
					'controller'=>'songs',
					'action' => 'view',
					'artist' => $song['Artist'][0]['slug'],
					'album' => $song['Album'][0]['slug'],
					'song' => $song['Song']['slug']
				), array(
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

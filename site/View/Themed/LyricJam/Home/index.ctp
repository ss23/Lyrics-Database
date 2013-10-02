<h2>
	Hot Artists
	<?php
		echo $this->Html->link('More Artists', array(
			'controller' => 'artists', 'action' => 'index', 'start' => 'all',
		), array(
			'class' => 'btn btn-default btn-xs',
		)
	); ?>
</h2>

<div id="hot-artists" class="carousel slide pull-left">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  	<?php
  		$i = 0;
  		foreach ($hot_artists as $artist) {
			echo '<li data-target="#hot-artists" data-slide-to="'.$i.'" '.(($i++ == 0)?'class="active"':'').'></li>';
		}
	?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
	<?php 
		$i = 0;
		foreach ($hot_artists as $artist) {
	?>
		<div class="item <?php if ($i++ == 0) echo "active" ?>">
			<a href="<?php echo Router::url(array('action' => 'view', 'controller' => 'artists', 'artist' => $artist['Artist']['slug'])) ?>">
				<?php echo $this->Html->image($artist['Art'], array('alt' => $artist['Artist']['name'])) ?>
				<div class="carousel-caption">
					<h2><?php echo h($artist['Artist']['name']); ?></h2>
				</div>
			</a>
		</div>
	<?php } ?>
  </div>
  
  <!-- Controls -->
  <a class="left carousel-control" href="#hot-artists" data-slide="prev">
    <span class="icon-prev"></span>
  </a>
  <a class="right carousel-control" href="#hot-artists" data-slide="next">
    <span class="icon-next"></span>
  </a>
</div>

<div class="fancy-holder pull-left">
	<?php
	$first = true;
	foreach ($hot_artists as $artist) {
		if ($first) {
			$first = false;
			echo '<div class="fancy-item active">';
		} else {
			echo '<div class="fancy-item">';
		}
		echo '<div class="col-md-3">' . h($artist['Artist']['name']) . '<div class="arrow"></div></div>';
		echo '<div class="col-md-9 artist-top-tracks">';
		$i = 0;
		foreach ($artist['Song'] as $song) {
			if ($i++ == 5)
				break;
			$number = $this->Html->tag('span', $i, array(
				'style' => 'font-size:'.(28-$i*3).'px',
			));
			echo $this->Html->link($number . $this->Html->image($this->Thumbnail->get($song['Album'][0])) . $song['Song']['name'], array(
					'action' => 'view',
					'controller' => 'songs',
					'artist' => $song['Artist'][0]['slug'],
					'album' => $song['Album'][0]['slug'],
					'song' => $song['Song']['slug'],
			), array(
				'escape' => false,
			));
		}
		echo "</div>";
		echo "</div>";
	}
	?>
</div>

<div class="clearfix"></div>

<?php

?>

<h2>
	Hot Tracks
	<?php
		echo $this->Html->link('More Songs', array(
				'action' => 'index',
				'controller' => 'songs',
			), array(
				'class' => 'btn btn-default btn-xs',
			)
		);
	?>
</h2>
<div class="list-group">
<?php
foreach ($hot_songs as $song) {
	$html = $this->Html->image($song['Art'], array('alt' => $song['Song']['Song']['name']));
	$html .= '<div class="caption text-center">' . h($song['Song']['Song']['name']) . '</div>';
	echo $this->Html->link($html, array(
		'action' => 'view',
		'controller' => 'songs',
		'artist' => $song['Song']['Artist'][0]['slug'],
		'album' => $song['Song']['Album'][0]['slug'],
		'song' => $song['Song']['Song']['slug'],
	), array('escape'=>false, 'class'=>'col-xs-4 col-sm-3 col-md-2 thumbnail'));
}
?>
</div>

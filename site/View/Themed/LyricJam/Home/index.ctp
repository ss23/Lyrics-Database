<h2>Hot Artists</h2>
<div class="fancy-holder">
	<?php
	$first = true;
	foreach ($hot_artists as $artist) {
		if ($first) {
			$first = false;
			echo '<div class="fancy-item active">';
		} else {
			echo '<div class="fancy-item">';
		}
		echo '<div class="col-md-3">' . h($artist['Artist']['Artist']['name']) . '<div class="arrow"></div></div>';
		echo '<div class="col-md-9">';
		echo $this->Html->link('Find Lyrics', array(
			'action' => 'view',
			'controller' => 'artists',
			'id' => $artist['Artist']['Artist']['id'],
			'slug' => $this->Slug->slugify($artist['Artist']['Artist']['name'])
		), array('escape'=>false, 'class'=>'btn btn-default'));
		echo $this->Html->image($artist['Art'], array(
				'alt' => $artist['Artist']['Artist']['name'],
				'class' => 'pull-right'
			)
		);
		echo "</div>";
		echo "</div>";
	}
	?>
	<div style="clear: both"></div>
</div>

<?php
echo $this->Html->link('More Artists', array(
		'action' => 'index',
		'controller' => 'artists',
	), array(
		'class' => 'btn btn-default',
	)
);
?>

<h2>Hot Tracks</h2>
<div class="list-group">
<?php
foreach ($hot_songs as $song) {
	$html = $this->Html->image($song['Art'], array('alt' => $song['Song']['Song']['name']));
	$html .= '<div class="caption text-center">' . h($song['Song']['Song']['name']) . '</div>';
	echo $this->Html->link($html, array(
		'action' => 'view',
		'controller' => 'songs',
		'id' => $song['Song']['Song']['id'],
		'slug' => $this->Slug->slugify($song['Song']['Song']['name']),
	), array('escape'=>false, 'class'=>'col-xs-4 col-sm-3 col-md-2 thumbnail'));
}
?>
</div>

<?php
echo $this->Html->link('More Songs', array(
		'action' => 'index',
		'controller' => 'songs',
	), array(
		'class' => 'btn btn-default',
	)
);
?>

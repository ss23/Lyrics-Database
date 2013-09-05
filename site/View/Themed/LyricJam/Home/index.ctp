<h2>Hot Artists</h2>

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
			<a href="<?php echo Router::url(array('action' => 'view', 'controller' => 'artists', 'id' => $artist['Artist']['Artist']['id'], 'slug' => $this->Slug->slugify($artist['Artist']['Artist']['name']))) ?>">
				<?php echo $this->Html->image($artist['Art'], array('alt' => $artist['Artist']['Artist']['name'])) ?>
				<div class="carousel-caption">
					<h2><?php echo h($artist['Artist']['Artist']['name']); ?></h2>
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
		echo '<div class="col-md-3">' . h($artist['Artist']['Artist']['name']) . '<div class="arrow"></div></div>';
		echo '<div class="col-md-9">';
		echo h($artist['Artist']['Artist']['name']);
		echo "</div>";
		echo "</div>";
	}
	?>
	<div style="clear: both"></div>
</div>

<div class="clearfix"></div>

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

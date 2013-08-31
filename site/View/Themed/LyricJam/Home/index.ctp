<style>
	.fancy-holder {
		box-shadow: 0 1px 2px rgba(0,0,0,0.075);
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.075);
		background-color: #fff;
		border: 1px solid #ddd;
		border-radius: 4px;
		position: relative;
	}

	.fancy-holder > .fancy-item.active .arrow {
		display: inline;
		margin: 4px -28px 0 0;
		border-top: 1px solid #ddd;
		border-right: 1px solid #ddd;
		-webkit-box-shadow: 5px 0px 5px -3px rgba(51, 75, 103, 0.2);
		-moz-box-shadow: 5px 0px 5px -3px rgba(51, 75, 103, 0.2);
		box-shadow: 5px 0px 5px -3px rgba(51, 75, 103, 0.2);
		z-index: 3;
		height: 26px;
		width: 26px;
		background-color: #ebebeb;
		float: right;
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		transform: rotate(45deg);
	}

	.fancy-holder > .fancy-item > .col-md-3 {
		border-right: 1px solid #ddd;
		border-top: 1px solid #ddd;
		line-height: 34px;
		clear: left;
		float: left;
	}
	.fancy-holder > .fancy-item:first-child > .col-md-3 {
		border-top: none;
	}
	.fancy-holder > .fancy-item > .col-md-3:hover {
		background-color: #ebebeb;
		cursor: pointer;
	}
	.fancy-holder > .fancy-item > .col-md-9 {
		display: none;
	}
	.fancy-holder > .fancy-item.active > .col-md-9 {
		display: block;
		position: absolute;
		padding-right: 0px;
		height: 100%;
		margin-left: 285px; /* TODO: Make me responsive somehow */
	}
	.fancy-holder > .fancy-item.active > .col-md-9 > img.pull-right {
		height: 100%;
	}
	.fancy-holder > .fancy-item.active > .col-md-3 {
		background-color: #ebebeb;
	}
</style>
<h2>Hot Artists</h2>
<div class="fancy-holder">
	<?php
	$c = 0;
	foreach ($hot_artists as $artist) {
		if ($c > 8) {
			break;
		}
		$c++;
		if ($c == 1) {
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

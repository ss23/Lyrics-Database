<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        LyricJam - <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('lyricjam');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<div id="wrap">
	<div class="container">
		<div id="header">
			<h1>Lyric<span class="header-half2 btn-primary">Jam</span> <small>we serve lyrics and sometimes jam</small></h1>
		</div>
		<?php echo $this->element("navbar") ?>
		
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div> <!-- /container -->
</div> <!-- /wrap -->

<div id="footer">
	<div class="container">
		<p class="text-muted credit text-center">This is my foot. Is it <em>kawaii</em>?</p>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php echo $this->Html->script('lyricjam'); ?>
</body>
</html>

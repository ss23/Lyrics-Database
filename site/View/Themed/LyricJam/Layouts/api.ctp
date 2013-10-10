<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        LyricJam - <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta(
        'favicon.png',
        '/favicon.png',
        array('type' => 'icon')
    );

    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('lyricjam');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <meta name="google-translate-customization" content="77c6229477db75ef-fe79b7ad4b0f3571-g7193feb809dd436b-c"></meta>
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
		
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div> <!-- /container -->
</div> <!-- /wrap -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php echo $this->Html->script('lyricjam'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo Configure::read('google-analytics') ?>', 'lyricjam.com');
  ga('send', 'pageview');
</script>
</body>
</html>

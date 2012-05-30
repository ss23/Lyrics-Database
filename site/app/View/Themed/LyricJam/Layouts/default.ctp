<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        LyricJam - <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('lyricjam');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
<div id="container">
    <div id="header">
        <h1><?php echo $this->Html->link('LyricJam: we serve lyrics and sometimes jam', 'http://lyricjam.com'); ?></h1>
    </div>
    <div id="content">

        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>

    </div>
    <div id="footer">
        This is my foot. Is it <em>kawaii</em>?
    </div>
</div>
</body>
</html>

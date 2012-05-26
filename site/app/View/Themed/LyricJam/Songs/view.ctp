<div class="songs">
<h2><?php echo h($song['Song']['name']); ?></h2>
<h4><?php echo h($song['Artist'][0]['name']); ?></h4>
<?php echo nl2br(h($song['Song']['lyrics'])); ?>
</div>

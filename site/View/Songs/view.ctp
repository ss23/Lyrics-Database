<div class="songs view">
<h2><?php  echo __('Song');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($song['Song']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($song['Song']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lyrics'); ?></dt>
		<dd>
			<?php echo nl2br(h($song['Song']['lyrics'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uuid'); ?></dt>
		<dd>
			<?php echo h($song['Song']['uuid']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

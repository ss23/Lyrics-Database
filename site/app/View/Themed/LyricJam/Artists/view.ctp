<div class="artists view">
<h2><?php  echo __('Artist');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uuid'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['uuid']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Artists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Songs');?></h3>
	<?php if (!empty($artist['Song'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Lyrics'); ?></th>
		<th><?php echo __('Uuid'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($artist['Song'] as $song): ?>
		<tr>
			<td><?php echo $song['id'];?></td>
			<td><?php echo $song['name'];?></td>
			<td><?php echo $song['lyrics'];?></td>
			<td><?php echo $song['uuid'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'songs', 'action' => 'view', 'id' => $song['id'], 'slug' => $this->Slug->slugify($song['name']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

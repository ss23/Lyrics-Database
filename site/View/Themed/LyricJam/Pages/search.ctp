<h2>Search for <span class="text-success"><?php echo $query ?></span></h2>

<div class="songs index">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('lyrics');?></th>
			<th><?php echo $this->Paginator->sort('uuid');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($songs as $song): ?>
	<tr>
		<td><?php echo h($song['Song']['id']); ?>&nbsp;</td>
		<td><?php echo str_ireplace(h($query), "<strong>".h($query)."</strong>", h($song['Song']['name'])); ?>&nbsp;</td>
		<td><?php echo str_ireplace(h($query), "<strong>".h($query)."</strong>", h($song['Song']['lyrics'])); ?>&nbsp;</td>
		<td><?php echo h($song['Song']['uuid']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', 'id' => $song['Song']['id'], 'slug' => $this->Slug->slugify($song['Song']['name']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Albums'), array('controller' => 'albums', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Artists'), array('controller' => 'artists', 'action' => 'index')); ?> </li>
	</ul>
</div>

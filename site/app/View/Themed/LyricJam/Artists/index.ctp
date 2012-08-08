<div class="artists">
	<h2><?php echo __('Artists');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($artists as $artist): ?>
	<tr>
		<td><?php echo $this->Html->link($artist['Artist']['name'], array('action' => 'view', 'id' => $artist['Artist']['id'], 'slug' => $this->Slug->slugify($artist['Artist']['name']))); ?></td>

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
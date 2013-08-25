<div class="albums form">
<?php echo $this->Form->create('Album');?>
	<fieldset>
		<legend><?php echo __('Add Album'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('uuid');
		echo $this->Form->input('Song');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Albums'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Songs'), array('controller' => 'songs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Song'), array('controller' => 'songs', 'action' => 'add')); ?> </li>
	</ul>
</div>

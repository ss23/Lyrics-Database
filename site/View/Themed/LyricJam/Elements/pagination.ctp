<?php
	if ($this->Paginator->hasPage(2)) {
		echo '<ul class="pagination col-md-12">';
		echo $this->Paginator->prev('&laquo; Prev', array('tag'=>'li', 'escape'=>false), null, array('tag'=>'li', 'escape'=>false, 'class' => 'disabled', 'disabledTag'=>'a'));
		echo $this->Paginator->numbers(array('tag'=>'li', 'separator' => '', 'currentTag'=>'a', 'currentClass'=>'active'));
		echo $this->Paginator->next('Next &raquo;', array('tag'=>'li', 'escape'=>false), null, array('tag'=>'li', 'escape'=>false, 'class' => 'disabled', 'disabledTag'=>'a'));
		echo '</ul>';
	}
?>
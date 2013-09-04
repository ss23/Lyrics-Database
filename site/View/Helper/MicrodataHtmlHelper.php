<?php

// Modifies the standard helper to use microdata sometimes

class MicrodataHtmlHelper extends HtmlHelper {
	
	public function getCrumbList($options = array(), $startText = false) {
		$defaults = array('firstClass' => 'first', 'lastClass' => 'last', 'separator' => '');
		$options = array_merge($defaults, (array)$options);
		$firstClass = $options['firstClass'];
		$lastClass = $options['lastClass'];
		$separator = $options['separator'];
		unset($options['firstClass'], $options['lastClass'], $options['separator']);
		$linkDefaults = array('escape' => false, 'itemprop' => 'url');

		$crumbs = $this->_prepareCrumbs($startText);
		if (empty($crumbs)) {
			return null;
		}

		$result = '';
		$crumbCount = count($crumbs);
		$ulOptions = $options;
		foreach ($crumbs as $which => $crumb) {
			$options = array();
			$crumb[0] = '<span itemprop="title">' . h($crumb[0]) . '</span>';
			if (empty($crumb[1])) {
				$elementContent = $crumb[0];
			} else {
				$elementContent = $this->link($crumb[0], $crumb[1], array_merge($linkDefaults, (array)$crumb[2]));
			}
			if (!$which && $firstClass !== false) {
				$options['class'] = $firstClass;
			} elseif ($which == $crumbCount - 1 && $lastClass !== false) {
				$options['class'] = $lastClass;
			}
			if (!empty($separator) && ($crumbCount - $which >= 2)) {
				$elementContent .= $separator;
			}
			$elementContent = $this->tag('li', $elementContent, $options);
			$result .= $this->tag('span', $elementContent, array(
				'itemscope',
				'itemtype' => 'http://data-vocabulary.org/Breadcrumb',
			));
		}
		return $this->tag('ul', $result, $ulOptions);				 
	}
}

<?php

class SlugLib {
	static function slugify($string, $slug = '-') {
		return strtolower(Inflector::slug($string, $slug));
	}
}
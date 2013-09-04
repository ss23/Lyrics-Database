<?php

class SlugLib {
	static function slugify($string, $slug = '-') {
		return utf8_encode(strtolower(Inflector::slug($string, $slug)));
	}
}
<?php

class ThumbnailHelper extends AppHelper {
	function get(array $album, $size='thumb') {
		if ($size != '') $size .= '_';
		$filename = "files/album/art/{$album['id']}/$size{$album['art']}";
		if (file_exists(WWW_ROOT.$filename))
			return '/'.$filename;
		else
			return "/img/{$size}album404.jpg";
	}
}
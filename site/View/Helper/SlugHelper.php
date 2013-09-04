<?php

App::uses('SlugLib', 'LyricJam');

    class SlugHelper extends AppHelper {
        function slugify($string, $slug = '-') {
			return SlugLib::slugify($string, $slug);
        }
    }
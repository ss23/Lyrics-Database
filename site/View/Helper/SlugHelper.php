<?php

    class SlugHelper extends AppHelper {
        function slugify($string, $slug = '-') {
            return utf8_encode(strtolower(Inflector::slug($string, $slug)));
        }
    }
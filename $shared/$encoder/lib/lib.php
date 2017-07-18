<?php

class Lib {

    public static function utf8($value) {
        return iconv(mb_detect_encoding($value, mb_detect_order(), true), 'UTF-8', $value);
    }

    public static function filterGet(array $except = array()) {
        $get = get();
        $filter = array();

        if (!empty($get)) {
            foreach ($get as $key => $value) {
                if (!empty($value) && !in_array($key, $except))
                    $filter['where'][$key] = $value;
            }
        }

        return $filter;
    }

    public static function alias($string, $delimiter = '_') {
        return strtolower(Inflector::slug($string, $delimiter));
    }

}

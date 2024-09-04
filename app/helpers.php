<?php

if (!function_exists('p')) {
    function p($data) {
        echo '<pre style="background:#eee;color:black;font-size:1em;margin:10px 0;padding:10px;white-space:pre-wrap">';
        print_r($data);
        echo "</pre>";
    }
}

if (!function_exists('objectToArray')) {
    function objectToArray($object) {
        if (!is_object($object) && !is_array($object))
            return $object;

        return array_map('objectToArray', (array)$object);
    }
}

<?php

/**
 * Helper function to construct url
 *
 * @param $arr
 * @return url string
 */
function url($arr) {
    $str = "/?";
    foreach ($arr as $key=>$value) {
        $str = $str . "$key=$value&";
    }
    return $str;
}
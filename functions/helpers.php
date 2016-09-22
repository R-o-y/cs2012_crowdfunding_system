<?php

/**
 * Helper function to construct url
 *
 * @param $arr
 * @return url string
 */
function url($arr) {
    $str = "./?";
    foreach ($arr as $key=>$value) {
        $str = $str . "$key=$value&";
    }
    return $str;
}

/**
 * Helper function to redirect
 *
 * @param $url
 */
function redirect($url) {
    header('Location: ' . $url);
}

/**
 * Truncate text
 *
 * @param $text
 * @param $length
 * @return mixed
 */
function truncateText($text, $length) {
    if(strlen($text) > $length) {
        $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
    }
    return $text;
}

/**
 * Plain text from rich html
 *
 * @param $html
 * @return mixed|string
 */
function plaintext($html)
{
    // remove comments and any content found in the the comment area (strip_tags only removes the actual tags).
    $plaintext = preg_replace('#<!--.*?-->#s', '', $html);

    // put a space between list items (strip_tags just removes the tags).
    $plaintext = preg_replace('#</li>#', ' </li>', $plaintext);

    // remove all script and style tags
    $plaintext = preg_replace('#<(script|style)\b[^>]*>(.*?)</(script|style)>#is', "", $plaintext);

    // remove br tags (missed by strip_tags)
    $plaintext = preg_replace("#<br[^>]*?>#", " ", $plaintext);

    // remove all remaining html
    $plaintext = strip_tags($plaintext);

    return $plaintext;
}
<?php
function get_base_url() {
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url = $protocol.$hostName.$pathInfo['dirname'];
    if (substr($url, -1) != '/') {
        $url .= '/';
    }
    return $url;
}

function truncate_str($str, $length, $beautiful = true) {
    //no need to trim, already shorter than trim length
    if (strlen($str) <= $length) {
        return $str;
    }

    if ($beautiful) {
        //find last space within length
        $last_space = strrpos(substr($str, 0, $length), ' ');
        $trimmed_text = substr($str, 0, $last_space);
    }
    else {
        $trimmed_text = substr($str, 0, $length);
    }
    $trimmed_text .= '...';

    return $trimmed_text;
}

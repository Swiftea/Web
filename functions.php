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

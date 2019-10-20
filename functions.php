<?php
function read_file($filename) {
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        if ($content !== false) {
            return $content;
        }
    }
}

// Get a value in cache by its name
function get_cache_value($name, $cache) {
    $json_data = read_file('cache/' . $cache . '.json');
    if ($json_data) {
        $values = json_decode($json_data, true);
        if (isset($values[$name])) {
            // Verify duration
            $seconds = 60 * 60 * $values[$name]['duration'];
            if((time() - $values[$name]['time']) < $seconds) {
                return $values[$name]['value'];
            }
        }
    }
}

// Save a value in cache with its name and a duration
function set_cache_value($name, $value, $cache, $hours=2) {
    $values = array();
    $json_data = read_file('cache/' . $cache . '.json');
    if ($json_data) {
        $values = json_decode($json_data, true);
    }
    $values[$name] = array(
        'value' => $value,
        'duration' => $hours,
        'time' => time()
    );
    if (!is_dir('cache')) {
        // dir doesn't exist, make it
        mkdir('cache');
    }
    file_put_contents('cache/' . $cache . '.json', json_encode($values));
}

function get_index_size($db, $lang='') {
    if ($lang) {
        $lang = '_' . $lang;
    }
    $index_size = get_cache_value('index_size' . $lang, 'values');
    if (!$index_size) {
        if ($lang) {
            $sql = 'SELECT count(*) FROM website WHERE language = :lang';
            $stmt = $db->prepare($sql);
            $stmt->execute(array(':lang' => substr($lang, 1)));
        }
        else {
            $sql = 'SELECT count(*) FROM website';
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $index_size = $stmt->fetchColumn();
        set_cache_value('index_size' . $lang, $index_size, 'values');
    }
    return $index_size;
}

function get_base_url() {
    $current_path = $_SERVER['PHP_SELF'];
    $path_info = pathinfo($current_path);
    $host_name = $_SERVER['HTTP_HOST'];
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url = $protocol . $host_name . $path_info['dirname'];
    if (substr($url, -1) != '/') {
        $url .= '/';
    }
    return $url;
}

function is_https($url) {
    return substr($url, 0, 8) === 'https://';
}

function truncate_str($str, $length, $beautiful = true) {
    // no need to trim, already shorter than trim length
    if (strlen($str) <= $length) {
        return $str;
    }

    if ($beautiful) {
        // find last space within length
        $last_space = strrpos(substr($str, 0, $length), ' ');
        $trimmed_text = substr($str, 0, $last_space);
    }
    else {
        $trimmed_text = substr($str, 0, $length);
    }
    $trimmed_text .= '...';

    return $trimmed_text;
}

function get_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function clean_domain($domain) {

    if (substr($domain, 0, 7) !== "http://" && substr($domain, 0, 8) !== "https://" ) {
        $domain = "http://" . $domain;
    }
    return parse_url($domain, PHP_URL_HOST);
}

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
function get_cache_value($name) {
    $json_data = read_file('cache/values.json');
    if ($json_data) {
        $values = json_decode($json_data, true);

        // Verify duration
        $seconds = 60 * 60 * $values[$name]['duration'];
        if((time() - $values[$name]['time']) < $seconds) {
            return $values[$name]['value'];
        }
    }
}

// Save a value in cache with its name and a duration
function set_cache_value($name, $value, $hours=2) {
    $values = array();
    $json_data = read_file('cache/values.json');
    if ($json_data) {
        $values = json_decode($json_data, true);
    }
    $values[$name] = array(
        'value' => $value,
        'duration' => $hours,
        'time' => time()
    );
    file_put_contents('cache/values.json', json_encode($values));
}

function get_index_size($db) {
    $index_size = get_cache_value('index_size');
    if (!$index_size) {
        $sql = 'SELECT count(*) FROM website';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $index_size = $stmt->fetchColumn();
        set_cache_value('index_size', $index_size);
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

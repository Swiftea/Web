<?php
require_once('config.php');
require_once('functions.php');
require_once('search-engine.php');

// Get the user request
$q = $search = htmlspecialchars(trim($_GET['q']));
$q = mb_strtolower($q);
$keywords = array_unique(explode(' ', $q));

$domain = clean_domain(htmlspecialchars(trim($_GET['d'])));

// Perform search

// Start domain crawler
$url = 'http://swifteasearch.alwaysdata.net/swiftea-server/start-crawler';
$data = array(
    'url' => 'http://' . $domain,
    'level' => '0',
    // 'target-level' => '1',
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* TODO: Handle error */ }

// Handle results
list($results, $nb_results, $real_nb_results, $pages, $page) = search($keywords, $domain);

echo json_encode($results);
?>

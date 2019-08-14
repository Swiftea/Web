<?php
// DB Connection

require_once('db.php');

// Vars

$languages = array('en', 'fr');
$index_folder = '../data/inverted_index/';
$index_ext = '.sif';
$min_length_keyword = 2;
$max_results_per_page = 10;
$max_results = 1000;
$max_api_access_free = 1000;

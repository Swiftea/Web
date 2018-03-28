<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB Connection

require_once('db.php');

// Vars

$languages = array('en', 'fr');
$index_folder = 'data/inverted_index/';
$index_ext = '.sif';
$max_results_per_page = 10;

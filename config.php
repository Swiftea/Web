<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB Connection
require('db.php');

// Vars
$languages = array('en', 'fr');
$index_folder = '../data/inverted_index/';
$index_ext = '.sif';
$min_length_keyword = 2;
$max_results_per_page = 10;
$max_results = 1000;

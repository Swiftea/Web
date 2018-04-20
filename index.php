<?php
require_once('config.php');
require_once('functions.php');

// Get page
if(isset($_GET['p']) && !empty($_GET['p'])) {
    $tmp_page = htmlspecialchars($_GET['p']);
    if(file_exists('pages/' . $tmp_page . '.php')) {
        $page = $tmp_page;
    }
    else {
        $page = '404';
        header('Status: 404 Not Found');
    }
}
else {
    $page = 'home';
}

// Call $page
require_once('templates/header.php');
require_once('pages/' . $page . '.php');
require_once('templates/footer.php');
?>

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
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Swiftea - Moteur de recherche open source</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/master.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="assets/img/icon-256x256-dark-round.png">
    <body>
        <div id="wrapper">
            <header id="header">
                <a href="<?php echo get_base_url(); ?>"><img src="assets/img/logo-112x35.png" alt="Swiftea"></a>
            </header>

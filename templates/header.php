<?php
require_once('config.php');
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <?php
        if (basename($_SERVER['PHP_SELF'], '.php') == 'index') {
            echo '<title>Swiftea - Moteur de recherche open source</title>';
        }
        else {
            if (!isset($title)) {
                $title = '';
            }
            else {
                $title .= ' - ';
            }
            echo '<title>' . $title . 'Swiftea</title>';
        }
        ?>
        <meta name="description" content="Swiftea est un moteur de recherche open-source. ">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/master.css">
        <link rel="stylesheet" href="assets/css/prism.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/solid.js" integrity="sha384-Q7KAHqDd5trmfsv85beYZBsUmw0lsreFBQZfsEhzUtUn5HhpjVzwY0Aq4z8DY9sA" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/fontawesome.js" integrity="sha384-M2FSA4xMm1G9m4CNXM49UcDHeWcDZNucAlz1WVHxohug0Uw1K+IpUhp/Wjg0y6qG" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="assets/img/icon-256x256-dark-round.png">
        <link rel="search" type="application/opensearchdescription+xml" title="Swiftea" href="swiftea.xml">
    <body>
        <div id="wrapper">
            <header id="header">
                <a href="<?php echo get_base_url(); ?>"><img src="assets/img/logo-112x35.png" alt="Swiftea"></a>
            </header>

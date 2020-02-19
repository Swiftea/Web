<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        if (!isset($title)) {
            $title = '';
        }
        else {
            $title .= ' - ';
        }
        echo '<title>' . $title . 'Swiftea</title>';
        ?>
        <meta name="description" content="Drive research on your website with our powerful & deep analysis tool!">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/master.min.css">
        <link rel="stylesheet" href="assets/css/prism.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script src="https://kit.fontawesome.com/95303e0f2f.js"></script>
        <link rel="icon" type="image/png" href="assets/img/icon-256x256-dark-round.png">
        <link rel="search" type="application/opensearchdescription+xml" title="Swiftea" href="swiftea.xml">
    <body>
        <div id="wrapper">
            <header id="header">
                <a href="<?php echo get_base_url(); ?>"><img src="assets/img/logo-112x35.png" alt="Swiftea"></a>
            </header>

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
        <meta name="description" content="Get data on many websites for your needs by using our free and open-source database of thousands of websites with the help of our API.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/master.css">
        <link rel="stylesheet" href="assets/css/prism.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="icon" type="image/png" href="assets/img/icon-256x256-dark-round.png">
        <link rel="search" type="application/opensearchdescription+xml" title="Swiftea" href="swiftea.xml">
    <body>
        <div id="wrapper">
            <header id="header">
                <a href="<?php echo get_base_url(); ?>"><img src="assets/img/logo-112x35.png" alt="Swiftea"></a>
            </header>

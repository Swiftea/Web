<?php
$title = 'Open Source Database and API of the web';
require_once('templates/header.php');
?>

<section id="search">
    <a href="<?php echo get_base_url(); ?>" id="logo"><img src="assets/img/logo-241x75.png" alt="Swiftea"></a>

    <form method="GET" action="search">
        <input type="search" name="q" placeholder="Your search..." autocomplete="off" autofocus required>
        <button type="submit" class="btn"><i class="fas fa-search"></i> Search</button>
    </form>
</section>

<?php require_once('templates/footer.php'); ?>

<?php require_once('templates/header.php'); ?>

<section id="search">
    <a href="<?php echo get_base_url(); ?>" id="logo"><img src="assets/img/logo-241x75.png" alt="Swiftea"></a>

    <form method="GET" action="search">
        <input type="search" name="search" placeholder="Votre recherche..." autocomplete="off" autofocus>
        <button type="submit"><i class="fas fa-search"></i> Rechercher</button>
    </form>
</section>

<?php require_once('templates/footer.php'); ?>

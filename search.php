<?php require_once('templates/header.php'); ?>

<section id="search" class="search-inline">
    <form method="GET" action="search.php">
        <input type="search" name="search" placeholder="Votre recherche..." autocomplete="off" autofocus value="<?php echo htmlspecialchars($_GET['search']); ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
</section>

<?php require_once('templates/footer.php'); ?>

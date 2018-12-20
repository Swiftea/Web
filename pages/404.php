<?php
$title = 'Erreur 404';
require_once('templates/header.php');
?>

<section class="page">
    <h1>Error 404</h1>

    <div class="card align-center">
        <h2>This page doesn't exist...</h2>

        <p>Don't worry, you can return to the <a href="<?php echo get_base_url(); ?>">homepage</a>.</p>

        <img src="assets/img/404.gif" alt="">
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

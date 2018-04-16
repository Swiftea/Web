<?php
$title = 'Erreur 404';
require_once('templates/header.php');
?>

<section class="page">
    <h1>Erreur 404</h1>

    <div class="card align-center">
        <h2>Cette page n'existe pas...</h2>

        <p>Pas d'inquiétude, vous pouvez revenir à <a href="<?php echo get_base_url(); ?>">l'accueil</a>.</p>

        <img src="assets/img/404.gif" alt="">
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

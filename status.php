<?php
require_once('templates/header.php');

$index_size = get_index_size($db);
?>

<section class="page">
    <h1>Statut</h1>

    <div class="card">
        <h2>Données</h2>
        <p>Nombre de pages web indexées : <b><?php echo $index_size; ?></b></p>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

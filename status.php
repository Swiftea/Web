<?php
require_once('templates/header.php');
?>

<section class="page">
    <h1>Statut</h1>

    <h2>Swiftea</h2>
    <div class="card">
        <p>HTTPS : <i class="fas fa-<?php echo is_https(get_base_url()) ? 'check' : 'times'; ?>"></i></p>
    </div>

    <h2>Données</h2>
    <div class="card">
        <p>Nombre de pages web indexées : <b><?php echo get_index_size($db); ?></b></p>
        <p>Nombre de pages web indexées par langue :</p>
        <ul>
            <?php
            foreach ($languages as $language) {
                echo '<li>' . $language . ' : <b>' . get_index_size($db, $language) . '</b></li>';
            }
            ?>
        </ul>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

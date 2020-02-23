<?php
$title = 'Status';
require_once('templates/header.php');
?>

<section class="page">
    <h1>Status</h1>

    <h2>Data</h2>
    <div class="card">
        <p>Number of indexed webpages: <b><?php echo number_format(get_index_size($db), 0, ',', ' '); ?></b></p>
        <p>Number of indexed webpages by language:</p>
        <ul>
            <?php
            foreach ($languages as $language) {
                echo '<li>' . strtoupper($language) . ': <b>' . number_format(get_index_size($db, $language), 0, ',', ' ') . '</b></li>';
            }
            ?>
        </ul>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

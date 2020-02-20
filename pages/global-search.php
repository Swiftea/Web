<?php
$title = 'Drive research on your website!';
require_once('templates/header.php');
?>

<section id="search">
    <a href="<?php echo get_base_url(); ?>" id="logo"><img src="assets/img/logo-241x75.png" alt="Swiftea"></a>

	<form method="GET" action="internal-search-result">
        <input type="search" name="q" placeholder="Your search..." autocomplete="off" autofocus>
        <input type="text" name="d" placeholder="Website url" autocomplete="off" autofocus>
        <button type="submit" class="btn"><i class="fas fa-search"></i> Search in a website</button>
    </form>

</section>

<?php require_once('templates/footer.php'); ?>

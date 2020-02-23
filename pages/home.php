<?php
$title = 'Drive research on your website!';
require_once('templates/header.php');
?>

<section id="search">
    <a href="<?php echo get_base_url(); ?>" id="logo"><img src="assets/img/logo-241x75.png" alt="Swiftea"></a>

	<form method="GET" action="internal-search-result">
        <input type="search" name="q" placeholder="Your search" autofocus required>
        <input type="text" name="d" placeholder="The URL of the site you want to browse">
        <button type="submit" class="btn"><i class="fas fa-search"></i> Search in this website</button>
    </form>

</section>

<?php require_once('templates/footer.php'); ?>

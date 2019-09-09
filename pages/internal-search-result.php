<?php
// Get the user request

$q = $search = htmlspecialchars(trim($_GET['q']));
$q = mb_strtolower($q);
$keywords = array_unique(explode(' ', $q));
$nb_keywords = count($keywords);

$domain = htmlspecialchars(trim($_GET['d']));

$title = 'Internal search | ' . $search;
require_once('templates/header.php');
require_once('search-engine.php');

// Perform search
list($results, $nb_results, $real_nb_results) = search($keywords, $domain);

?>

<section id="search" class="search-inline search-inline">
    <p>Search in this website: <?php echo $domain; ?></p>
    <form method="GET" action="internal-search-result">
        <input type="search" name="q" placeholder="Your search..." autocomplete="off" autofocus value="<?php echo $search; ?>" size="1" onfocus="var v=this.value; this.value=''; this.value=v" required>
        <input type="hidden" name="d" value="<?php echo $_GET['d']; ?>">
        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
    </form>
</section>

<section id="results">
    <?php
    if ($nb_results) {
        $str = $nb_results > 1 ? 'results' : 'result';
        echo '<span class="nb-results">' . $nb_results . ' ' . $str . ' - in ' . round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . 's</span>';
        foreach ($results as $result) {
            if (empty($result['favicon']) || !is_https($result['favicon'])) {
                $result['favicon'] = 'assets/img/default-favicon.png';
            }
        ?>
            <div class="result">
                <p class="result-title"><img src="<?php echo $result['favicon']; ?>" alt=""> <a href="<?php echo $result['url']; ?>"><?php echo truncate_str($result['title'], 80); ?></a></p>
                <p class="result-description"><?php echo truncate_str($result['description'], 150); ?></p>
                <p class="result-url <?php echo is_https($result['url']) ? 'secure' : ''; ?>">
                    <?php echo truncate_str($result['url'], 60, false); ?>
                </p>
            </div>
        <?php
        }
    }
    else {
        echo '<span class="nb-results">Any result...</span>';
    }
    ?>
</section>
<?php
if (isset($results) && $nb_results > $max_results_per_page) {
?>
    <nav id="pagination">
        <ul>
            <?php
            $url = 'internal-search-result?q=' . $_GET['q'] . '&d=' . $_GET['d'] . '&p=';

            if ($page > 2) {
                echo '<li><a href="' . $url . '1"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a></li>';
            }
            if ($page > 1) {
                echo '<li><a href="' . $url . ($page - 1) . '"><i class="fas fa-angle-left"></i></a></li>';
            }
            echo '<li class="disabled"><span>Page ' . $page . '</span></li>';
            if ($page < $pages) {
                echo '<li><a href="' . $url . ($page + 1) . '">Next <i class="fas fa-angle-right"></i></a></li>';
            }
            ?>
        </ul>
    </nav>
<?php
}

require_once('templates/footer.php');
?>

<?php
// Get the user request

$q = $search = htmlspecialchars(trim($_GET['q']));
$q = mb_strtolower($q);
$keywords = array_unique(explode(' ', $q));

$title = 'Search | ' . $search;
require_once('templates/header.php');
require_once('search-engine.php');

// Perform search
list($results, $nb_results, $real_nb_results) = search($keywords, '');
?>

<section id="search" class="search-inline">
    <form method="GET" action="search">
        <input type="search" name="q" placeholder="Your search..." autocomplete="off" autofocus value="<?php echo $search; ?>" size="1" onfocus="var v=this.value; this.value=''; this.value=v" required>
        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
    </form>
</section>

<section id="results">
    <?php
    if ($nb_results) {
        $str = $nb_results > 1 ? 'results' : 'result';
        if ($real_nb_results >= $max_results) {
            $nb_results_str = '+' . number_format($max_results, 0, ',', ' ');
        }
        else {
            $nb_results_str = number_format($nb_results, 0, ',', ' ');
        }
        echo '<span class="nb-results">' . $nb_results_str . ' ' . $str . ' - in ' . round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . 's</span>';
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
            $url = 'search?q=' . $_GET['q'] . '&p=';

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

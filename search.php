<?php
require_once('templates/header.php');

// Get the user request

$q = $search = trim(htmlspecialchars($_GET['q']));
$q = mb_strtolower($q);
$keywords = array_unique(explode(' ', $q));

// Find the files to read in the inverted index

$files = array();

foreach($keywords as $keyword) {
    $first_letter = mb_substr($keyword, 0, 1);
    $second_letter = mb_substr($keyword, 1, 1);
    $two_letters = $first_letter . $second_letter;

    if(ctype_alpha($two_letters)) {
        $file = strtoupper($first_letter) . '/' . $two_letters . $index_ext;
    }
    else {
        if(ctype_lower($first_letter)) {
            $file = strtoupper($first_letter) . '/' . $first_letter . '-sp' . $index_ext;
        }
        elseif(ctype_lower($second_letter)) {
            $file = 'SP/sp-' . $second_letter . $index_ext;
        }
        else {
            $file = 'SP/sp-sp' . $index_ext;
        }
    }

    if(!in_array($file, $files)) {
        $files[] = $file;
    }
}

// Read the inverted-index

$words = array();

// For each language folder (ex: en)
foreach ($languages as $language) {
    // For each files to open (ex: aa.sif)
    foreach($files as $file) {
        $path = $index_folder . strtoupper($language) . '/' . $file;
        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);
            // For each keyword of query
            foreach($keywords as $keyword) {
                // If this keyword is in the inverted-index
                if(isset($json[$keyword])) {
                    if(!isset($words[$keyword]['nb_results'])) {
                        $words[$keyword]['nb_results'] = 0;
                    }

                    // For each website
                    foreach($json[$keyword] as $id => $tf) {
                        $words[$keyword]['results'][$id] = $tf;
                        $words[$keyword]['nb_results'] += 1;
                    }
                }
            }
            unset($json);
        }
    }
}

// Ranking

if(!empty($words)) {
    // Get number of websites in our index
    $sql = 'SELECT count(*) FROM website';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $index_size = $stmt->fetchColumn();

    $rank_results = array();

    // #1 TF-IDF
    foreach ($words as $keyword => $ids_per_word) {
        $idf = log($index_size / $ids_per_word['nb_results']);

        foreach($ids_per_word['results'] as $id => $tf) {
            $tf_idf = ($ids_per_word['results'][$id] * $idf);
            if(!isset($rank_results[$id])) {
                // Create it
                $rank_results[$id] = $tf_idf;
            }
            else {
                // Update it
                $rank_results[$id] += $tf_idf;
            }
        }
        unset($idf);
    }

    $nb_results = count($rank_results);

    $ids_array = array_keys($rank_results);
    $in = str_repeat('?,', $nb_results - 1) . '?';

    $sql = "SELECT url, popularity, score, homepage FROM website WHERE id IN ($in)";
    $stmt = $db->prepare($sql);
    $stmt->execute($ids_array);
    $criterias = $stmt->fetchAll();

    // #2 Score, #3 Popularity
    for ($i = 0; $i < $nb_results; $i++) {
        switch ($criterias[$i]['score']) {
            case '1':
                $score = 0.25;
                break;
            case '2':
                $score = 0.5;
                break;
            case '3':
                $score = 0.75;
                break;
        }

        $popularity = $criterias[$i]['popularity'] * 0.05;
        $homepage = ($criterias[$i]['homepage'] == '1') ? 1 : 0;

        $spam = ($rank_results[$ids_array[$i]] > 1) ? true : false;

        $rank_results[$ids_array[$i]] += log($score + $homepage + $popularity);

        if ($spam) {
            $rank_results[$ids_array[$i]] /= 3;
        }
    }

    unset($criterias); unset($files); unset($words);

    arsort($rank_results);

    $ids_array = array_keys($rank_results);

    // Pagination

    $page = isset($_GET['p']) && ctype_digit(strval($_GET['p'])) ? $_GET['p'] : 1;
    $pages = ceil($nb_results / $max_results_per_page);

    $first_site = ($page - 1) * $max_results_per_page;

    // Get final results

    $final_ids_array = array_slice($ids_array, $first_site, $max_results_per_page);
    $in = str_repeat('?,', $max_results_per_page - 1) . '?';

    $sql = "SELECT title, description, url, favicon FROM website WHERE id IN ($in)";
    $stmt = $db->prepare($sql);
    $stmt->execute($final_ids_array);
    $results = $stmt->fetchAll();
}
?>

<section id="search" class="search-inline">
    <form method="GET" action="search">
        <input type="search" name="q" placeholder="Votre recherche..." autocomplete="off" autofocus value="<?php echo $search; ?>" size="1" onfocus="var tmp=this.value; this.value=''; this.value=tmp">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
</section>

<section id="results">
    <?php
    if (isset($results)) {
        foreach ($results as $result) {
            if ((empty($result['favicon'])
                || substr($result['favicon'], 0, 8) !== 'https://')
            ) {
                $result['favicon'] = 'assets/img/default-favicon.png';
            }
        ?>
            <div class="result">
                <p class="result-title"><img src="<?php echo $result['favicon']; ?>" alt=""> <a href="<?php echo $result['url']; ?>"><?php echo $result['title']; ?></a></p>
                <p class="result-description"><?php echo $result['description']; ?></p>
                <p class="result-url"><?php echo $result['url']; ?></p>
            </div>
        <?php
        }
    }
    else {
    ?>
        Aucun résultat...
    <?php
    }
    ?>
</section>
<?php
if (isset($results)) {
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
                echo '<li><a href="' . $url . ($page + 1) . '">Suivante <i class="fas fa-angle-right"></i></a></li>';
            }
            ?>
        </ul>
    </nav>
<?php
}

require_once('templates/footer.php');
?>

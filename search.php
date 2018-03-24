<?php
require_once('templates/header.php');

$q = $search = trim(htmlspecialchars($_GET['q']));
$q = mb_strtolower($q);
$keywords = array_unique(explode(' ', $q));

// Find the files to read

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

$websites_id = array();

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
                    if(!isset($websites_id[$keyword]['nb_results'])) {
                        $websites_id[$keyword]['nb_results'] = 0;
                    }

                    // For each website
                    foreach($json[$keyword] as $id => $tf) {
                        $websites_id[$keyword]['results'][$id] = $tf;
                        $websites_id[$keyword]['nb_results'] += 1;
                    }
                }
            }
            unset($json);
        }
    }
}

$json = null;

// Ranking

if(!empty($websites_id)) {
    $rank_results = array();
    $str_results = implode(',', array_keys($rank_results));

    $sql = 'SELECT count(*) FROM website';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $index_size = $stmt->fetchColumn();

    // #1 TF-IDF
    foreach ($websites_id as $keyword => $ids_per_word) {
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

    $in_array = array_keys($rank_results);
    $in = str_repeat('?,', $nb_results - 1) . '?';

    $sql = "SELECT url, popularity, score, homepage FROM website WHERE id IN ($in)";
    $stmt = $db->prepare($sql);
    $stmt->execute($in_array);
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

        $spam = ($rank_results[$in_array[$i]] > 1) ? true : false;

        $rank_results[$in_array[$i]] += log($score + $homepage + $popularity);

        if ($spam) {
            $rank_results[$in_array[$i]] /= 3;
        }
    }

    $files = $websites_id = $in_array = $criterias = null;
    unset($criterias); unset($files); unset($websites_id);

    arsort($rank_results);

    $in_array = array_keys($rank_results);

    $sql = "SELECT * FROM website WHERE id IN ($in)";
    $stmt = $db->prepare($sql);
    $stmt->execute($in_array);
    $results = $stmt->fetchAll();

    unset($in_array);
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

<?php require_once('templates/footer.php'); ?>

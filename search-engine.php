<?php
// Find the files to read in the inverted index
function get_filenames($keywords) {
    require('config.php');
    $files = array();

    foreach ($keywords as $keyword) {
        if (strlen($keyword) < $min_length_keyword) {
            continue;
        }
        $first_letter = mb_substr($keyword, 0, 1);
        $second_letter = mb_substr($keyword, 1, 1);
        $two_letters = $first_letter . $second_letter;

        if (ctype_alpha($two_letters)) {
            $file = strtoupper($first_letter) . '/' . $two_letters . $index_ext;
        }
        else {
            if (ctype_lower($first_letter)) {
                $file = strtoupper($first_letter) . '/' . $first_letter . '-sp' . $index_ext;
            }
            elseif (ctype_lower($second_letter)) {
                $file = 'SP/sp-' . $second_letter . $index_ext;
            }
            else {
                $file = 'SP/sp-sp' . $index_ext;
            }
        }

        if (!in_array($file, $files)) {
            $files[] = $file;
        }
    }
	return $files;
}

// Read the inverted-index
function read_invert_index($files, $keywords) {
    require('config.php');
    $words = array();

    // For each language folder (ex: en)
    foreach ($languages as $language) {
        // For each file to open (ex: aa.sif)
        foreach ($files as $file) {
            $path = $index_folder . strtoupper($language) . '/' . $file;
            if (file_exists($path)) {
                $json = json_decode(file_get_contents($path), true);
                // For each keyword of query
                foreach ($keywords as $keyword) {
                    // If this keyword is in the inverted-index
                    if (isset($json[$keyword])) {
                        if (!isset($words[$keyword]['nb_results'])) {
                            $words[$keyword]['nb_results'] = 0;
                        }

                        // For each website
                        foreach ($json[$keyword] as $id => $tf) {
                            $words[$keyword]['results'][$id] = $tf;
                            $words[$keyword]['nb_results'] += 1;
                        }
                    }
                }
            }
        }
    }
    return $words;
}

// Ranking
function compute_tfidf($words, $index_size) {
    require('config.php');
    $rank_results = array();

    // #1 TF-IDF
    foreach ($words as $word => $ids_per_word) {
        $idf = log($index_size / $ids_per_word['nb_results']);

        foreach ($ids_per_word['results'] as $id => $tf) {
            $tf_idf = ($ids_per_word['results'][$id] * $idf);
            if (!isset($rank_results[$id])) {
                // Create it
                $rank_results[$id] = $tf_idf;
            }
            else {
                // Update it
                $rank_results[$id] += $tf_idf;
            }
        }
    }
    return $rank_results;
}

function search($keywords, $domain) {
    require('config.php');
    require('db.php');
    $nb_keywords = count($keywords);
    // Find the files to read in the inverted index
    if ($nb_keywords > 0) {
        $files = get_filenames($keywords, $min_length_keyword, $index_ext);
    }

    // Read the inverted-index
    if (isset($files) && !empty($files)) {
        $words = read_invert_index($files, $keywords, $languages, $index_folder);
    }

    $results = array();
    $nb_results = 0;
    $real_nb_results = 0;
    $pages = 1;
    $page = 1;

    // Ranking
    if (isset($words) && !empty($words)) {
        // Get number of websites in our index
        $index_size = get_index_size($db);

        $rank_results = compute_tfidf($words, $index_size);

        if (count($rank_results) > 0) {
            // Limit results to $max_results
            arsort($rank_results);

            $rank_results = array_slice($rank_results, 0, $max_results, true);

            $real_nb_results = count($rank_results);
            $ids_array = array_keys($rank_results);
            $in = str_repeat('?,', $real_nb_results - 1) . '?';

            if ($domain !== '') {
                $sql = "SELECT id, url, popularity, score, homepage FROM website w WHERE id IN ($in) AND w.domain LIKE '%$domain%'";
            }
            else {
                $sql = "SELECT id, url, popularity, score, homepage FROM website WHERE id IN ($in)";
            }
            $stmt = $db->prepare($sql);
            $stmt->execute($ids_array);
            $websites = $stmt->fetchAll();

            // #2 Score, #3 Popularity, #4 Homepage, #5 URL
            $rank_results2 = array();

            foreach ($websites as $website) {
                $rank_results2[$website['id']] = $rank_results[$website['id']];

                $score = $website['score'] / 4;
                $popularity = $website['popularity'] * 0.05;
                $homepage = 0;
                if ($nb_keywords == 1 && $website['homepage'] == '1') {
                    $homepage = 1;
                }
                $keyword_url = 0;
                foreach ($keywords as $keyword) {
                    if (strpos($website['url'], $keyword) !== false) {
                        $keyword_url = 2;
                        break;
                    }
                }

                $spam = ($rank_results2[$website['id']] > 1) ? true : false;

                $rank_results2[$website['id']] += log($score + $popularity + $homepage + $keyword_url);

                if ($spam) {
                    $rank_results2[$website['id']] /= 3;
                }
            }
        }

        $nb_results = count($rank_results2); // Real number of results (after SQL query)

        if ($nb_results > 0) {
            arsort($rank_results2); // Sort the results by their final score

            $ids_array = array_keys($rank_results2);

            // Pagination
            $pages = ceil($nb_results / $max_results_per_page);

            $page = isset($_GET['p']) && ctype_digit(strval($_GET['p'])) ? $_GET['p'] : 1;
            if ($page < 1 || $page > $pages) {
                $page = 1;
            }

            $first_site = ($page - 1) * $max_results_per_page;
            $final_ids_array = array_slice($ids_array, $first_site, $max_results_per_page);
            $nb_ids = count($final_ids_array);
            $in = str_repeat('?,', $nb_ids - 1) . '?';

            // Get final results

            $sql = "SELECT title, description, url, favicon FROM website WHERE id IN ($in)";
            $stmt = $db->prepare($sql);
            $stmt->execute($final_ids_array);
            $results = $stmt->fetchAll();
        }
    }

    return array($results, $nb_results, $real_nb_results, $pages, $page);
}
?>

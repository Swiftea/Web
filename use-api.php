<?php require_once('templates/header.php'); ?>

<section class="page">
    <h1>API</h1>
    <p>Nous mettons à votre disposition notre base de données de plus de <b><?php echo floor(get_index_size($db) / 100) * 100; ?> pages</b> différentes.</p>

    <h2>À quoi sert cette API ?</h2>
    <div class="card">
        <p>Notre API vous permet d'accéder à des données sur les pages de votre choix. Vous pouvez vous en servir afin de réaliser par exemple des listes de sites, des comparatifs. Vous pourrez ainsi accéder aux titres, aux descriptions, aux favicons et à bien d'autres données de ces page web.</p>
    </div>

    <h2>Prix</h2>
    <div>
        <div class="card card-50 api-price">
            <h3><i class="fas fa-flag"></i> Start - 0€</h3>
            <ul>
                <li>100 requêtes par jour</li>
                <li>
                    Accès aux données suivantes :
                    <ul>
                        <li>Titre</li>
                        <li>Description</li>
                        <li>URL du favicon</li>
                    </ul>
                </li>
                <li>Une langue disponible au choix</li>
            </ul>
            <a href="#start" class="btn"><i class="fas fa-code"></i> Essayer</a>
        </div><div class="card card-50 api-price api-premium">
            <h3><i class="fas fa-space-shuttle"></i> Premium</h3>
            <ul>
                <li>10 000 requêtes par jour</li>
                <li>
                    Accès aux données suivantes :
                    <ul>
                        <li>Titre</li>
                        <li>Description</li>
                        <li>URL du favicon</li>
                        <li>Indice SaneSearch</li>
                        <li>Indice de qualité</li>
                        <li>Dates du premier et du dernier crawl</li>
                    </ul>
                </li>
                <li>Toutes les langues supportées par Swiftea</li>
            </ul>
            <a href="#" class="btn"><i class="fas fa-shopping-cart"></i> Bientôt disponible</a>
        </div>
    </div>

    <h2>Comment utiliser l'API en version Start ?</h2>
    <div id="start" class="card">
        <h3>Étape 1</h3>
        <p>Appelez l'adresse suivante <code class="language-markup"><?php echo get_base_url(); ?>api.php?url=</code> avec en paramètre l'URL dont vous souhaitez obtenir des informations.<br><br>
        Par exemple :<br>
        <code class="language-markup"><?php echo get_base_url(); ?>api.php?url=https://fr.yahoo.com</code></p>

        <h3>Étape 2</h3>
        <p>Vous allez ensuite récupérer une réponse au format JSON que vous allez pouvoir utiliser dans votre langage préféré.</p>
        <p>Par exemple :</p>
        <pre><code class="language-json">{"title":"Yahoo","description":"Actualit\u00e9s, mails et recherche... Ce n\u2019est que le d\u00e9but ! \u00c0 chaque jour sa nouvelle d\u00e9couverte... Explorez de nouveaux horizons.","favicon":"https:\/\/mbp.yimg.com\/sy\/rz\/l\/favicon.ico"}</code></pre>

        <h3>Étape 3</h3>
        <p>Il vous reste juste à parser cette réponse afin d'en faire une variable utilisable dans le langage de votre choix.<br><br>

        <?php $code = '$json = file_get_contents(\'' . get_base_url() . 'api.php?url=https://fr.yahoo.com\');
$obj = json_decode($json);
$title = $obj->title;'; ?>
        Par exemple en PHP :</p>
        <pre><code class="language-php"><?php echo $code; ?></code></pre>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

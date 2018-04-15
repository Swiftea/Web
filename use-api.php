<?php require_once('templates/header.php'); ?>

<section class="page">
    <h1>API</h1>
    <p>Nous mettons à votre disposition notre base de données de + de <b><?php echo floor(get_index_size($db) / 100) * 100; ?> pages</b> différentes.</p>

    <h2>À quoi sert cette API ?</h2>
    <div class="card">
        <p>Notre API vous permet d'accéder à des données sur les pages de votre choix. Vous pouvez vous en servir afin de réaliser par exemple des listes de sites, des comparatifs... Vous pourrez ainsi accéder au titre du site, à sa description, à son favicon...</p>
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
        </div><div class="card card-50 api-price">
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

    <h2>Comment utiliser l'offre Start ?</h2>
    <div id="start" class="card">
        <ul>
            <li>Appelez l'url <code class="language-markup"><?php echo get_base_url(); ?>api.php?url=</code> suivi de l'URL de la page dont vous souhaitez obtenir des informations.</li>
            <li>Vous allez ensuite récupérer une réponse au format JSON que vous pourrez utiliser dans votre langage préféré.</li>
        </ul>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

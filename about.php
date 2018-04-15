<?php require_once('templates/header.php'); ?>

<section class="page">
    <h1>À propos</h1>
    <p>Swiftea est un moteur de recherche open-source développé par <a href="https://github.com/Thykof">Nathan Seva</a> et <a href="https://hugo-posnic.fr">Hugo Posnic</a> dans un but éducatif.</p>

    <h2>Open Source</h2>
    <div class="card">
        <p>
            Le code source est disponible <a href="https://github.com/Swiftea">sur GitHub</a> sous licence GNU GPL v3. Il fonctionne grâce à deux programmes :
        </p>
        <ul>
            <li><a href="https://github.com/Swiftea/Crawler">Crawler</a> : il parcoure le web afin de connaître un maximum de pages web. Il est codé en Python.</li>
            <li><a href="https://github.com/Swiftea/Web">Web</a> : il s'agit de l'interface qui vous présente les résultats de vos recherches. Elle est écrite en PHP.</li>
        </ul>
    </div>
    <h2>Classement des résultats</h2>
    <div class="card">
        <p>Les résultats que vous voyez apparaitre lorsque vous effectuez une recherche sont classés selon plusieurs critères :</p>
        <ul>
            <li>La méthode <a href="https://fr.wikipedia.org/wiki/TF-IDF">TF-IDF</a></li>
            <li>Un score calculé de manière unique pour chaque page</li>
            <li>Un indice de popularité mesuré par le crawler</li>
            <li>Les mots-clés dans l'adresse de chaque page</li>
        </ul>
        <p>Si une page abuse de l'utilisation de mots-clés optimisés, elle se voit pénalisée dans les résultats.</p>
    </div>
    <h2>Hébérgement</h2>
    <div class="card">
        <p>
            Le site web et la base de données sont stockés gratuitement chez l'hebérgeur PlanetHoster grâce à sa formule <a href="https://www.planethoster.net/fr/World-Lite">World Lite</a>.
        </p>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

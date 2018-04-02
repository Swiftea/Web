<?php require_once('templates/header.php'); ?>

<section class="page">
    <h1>À propos</h1>
    <p>Swiftea est un moteur de recherche open-source développé par <a href="https://github.com/Thykof">Nathan Seva</a> et <a href="https://hugo-posnic.fr">Hugo Posnic</a> dans un but éducatif.</p>

    <div class="card">
        <h2>Open Source</h2>
        <p>
            Le projet est <a href="https://github.com/Swiftea">disponible sur GitHub</a> sous licence GNU GPL v3. Il fonctionne grâce à deux programmes majeurs :
        </p>
        <ul>
            <li>Le <a href="https://github.com/Swiftea/Crawler">crawler</a> :</li>
            <p>Il parcoure le web afin de connaître un maximum de sites internet. Il est codé en Python.</p>
            <li>Le <a href="https://github.com/Swiftea/Web">site web</a> :</li>
            <p>Il s'agit de l'interface qui vous présente les résultats de vos recherches. Elle est écrite en PHP.</p>
        </ul>
    </div>
    <div class="card">
        <h2>Classement des résultats</h2>
        <p>Les résultats que vous voyez apparaitre lorsque vous effectuez une recherche sont classés selon plusieurs critères :</p>
        <ul>
            <li>La méthode <a href="https://fr.wikipedia.org/wiki/TF-IDF">TF-IDF</a></li>
            <li>Un score calculé de manière unique pour chaque page</li>
            <li>Un indice de popularité mesuré par le crawler</li>
        </ul>
        <p>Si une page abuse de l'utilisation de mots-clés optimisés, elle se voit pénalisée dans les résultats.</p>
    </div>
    <div class="card">
        <h2>Hébérgement</h2>
        <p>
            Le site web et la base de données sont stockés gratuitement chez l'hebérgeur PlanetHoster grâce à sa formule <a href="https://www.planethoster.net/fr/World-Lite">World Lite</a>.
        </p>
    </DIV>
</section>

<?php require_once('templates/footer.php'); ?>

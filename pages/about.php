<?php
$title = 'About';
require_once('templates/header.php');
?>

<section class="page">
    <h1>About</h1>
    <p>Swiftea is an open-source search engine developed by  <a href="https://github.com/Thykof">Nathan Seva</a> et <a href="https://hugo-posnic.fr">Hugo Posnic</a> for educational purpose.</p>

    <h2>Open Source</h2>
    <div class="card">
        <p>
            Source code is available <a href="https://github.com/Swiftea">on GitHub</a> under the GNU GPL v3 license. It works through two programs:
        </p>
        <ul>
            <li><a href="https://github.com/Swiftea/Crawler">Crawler</a>: it browses the web to know a maximum of webpages. It is coded in Python.</li>
            <li><a href="https://github.com/Swiftea/Web">Web</a>: this is the interface that shows you the results of your research. It is written in PHP.</li>
        </ul>
    </div>
    <h2>Ranking</h2>
    <div class="card">
        <p>The results you see when you perform a search are classified according to several criteria:</p>
        <ul>
            <li><a href="https://en.wikipedia.org/wiki/Tf–idf">TF-IDF</a> method</li>
            <li>A score calculated uniquely for each page</li>
            <li>A popularity index measured by the crawler</li>
            <li>The keywords in the address of each page</li>
        </ul>
        <p>If a page abuses the use of optimized keywords, it is penalized in the results.</p>
    </div>
    <h2>Hosting</h2>
    <div class="card">
        <p>
            The website and the database are stored free of charge at PlanetHoster thanks to its <a href="https://www.planethoster.net/fr/World-Lite">World Lite</a> formula.
        </p>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

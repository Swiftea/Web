<?php require_once('templates/header.php'); ?>

<section id="search" class="search-inline">
    <form method="GET" action="search">
        <input type="search" name="q" placeholder="Votre recherche..." autocomplete="off" autofocus value="<?php echo htmlspecialchars($_GET['q']); ?>" size="1" onfocus="var tmp=this.value; this.value=''; this.value=tmp">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
</section>

<section id="results">
    <div class="result">
        <p class="result-title"><img src="http://www.google.com/s2/favicons?domain=lemonde.fr" alt=""> <a href="#">Le Monde.fr - Actualités et Infos en France et dans le monde</a></p>
        <p class="result-description">Le Monde.fr - 1er site d'information. Les articles du journal et toute l'actualité en continu : International, France, Société, Economie, Culture, Environnement, Blogs ...</p>
        <p class="result-url">www.lemonde.fr</p>
    </div>
    <div class="result">
        <p class="result-title"><img src="http://www.google.com/s2/favicons?domain=agence-sence.fr/" alt=""> <a href="#">Sence • Agence web à Orléans : création de site web et design</a></p>
        <p class="result-description">Agence web jeune et créative, Sence développe avec vous votre site web, votre identité graphique et vous accompagne dans votre stratégie numérique</p>
        <p class="result-url">agence-sence.fr</p>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

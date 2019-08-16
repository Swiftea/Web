<?php
$title = 'API';
require_once('templates/header.php');
?>

<section class="page">
    <h1>API</h1>
    <p>We offer you our database of over <b><?php echo number_format(floor(get_index_size($db) / 100) * 100, 0, ',', ' '); ?> different webpages</b>.</p>

    <h2>What is this API for?</h2>
    <div class="card">
        <p>Our API allows you to access data on the webpages of your choice. You can use it to realize for example lists of sites, comparatives. You will be able to access the titles, descriptions, favicons and many other data of them.</p>
    </div>

    <h2>Offer</h2>
    <div>
        <div class="card card-50 api-price">
            <h3><i class="fas fa-flag"></i> Starter - 0€</h3>
            <ul>
                <li>1 000 requests per day</li>
                <div class="separator"></div>
                <li>
                    Access to this data:
                    <ul>
                        <li>Title</li>
                        <li>Description</li>
                        <li>Favicon URL</li>
                    </ul>
                </li>
            </ul>
            <a href="#starter" class="btn"><i class="fas fa-code"></i> Try it now</a>
        </div>
    </div>

    <h2>How to use the Starter API?</h2>
    <div id="starter" class="card">
        <h3>Step 1</h3>
        <p>Call this URL <code class="language-markup"><?php echo get_base_url(); ?>api.php?url=</code> with your URL in parameter.<br><br>
        For example:<br>
        <code class="language-markup"><?php echo get_base_url(); ?>api.php?url=https://fr.yahoo.com</code></p>

        <h3>Step 2</h3>
        <p>You will then retrieve a response in JSON format that you can use in your preferred language.</p>
        <p>For example:</p>
        <pre><code class="language-json">{"title":"Yahoo","description":"Actualit\u00e9s, mails et recherche... Ce n\u2019est que le d\u00e9but ! \u00c0 chaque jour sa nouvelle d\u00e9couverte... Explorez de nouveaux horizons.","favicon":"https:\/\/mbp.yimg.com\/sy\/rz\/l\/favicon.ico"}</code></pre>

        <h3>Step 3</h3>
        <p>You just have to parse this answer in order to make it a usable variable in the language of your choice.<br><br>

        <?php $code = '$json = file_get_contents(\'' . get_base_url() . 'api.php?url=https://fr.yahoo.com\');
$obj = json_decode($json);
$title = $obj->title;'; ?>
        For example in PHP:</p>
        <pre><code class="language-php"><?php echo $code; ?></code></pre>
    </div>
</section>

<?php require_once('templates/footer.php'); ?>

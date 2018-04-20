<?php
require_once('config.php');
header('Content-Type: application/json');

// Get the user request

$data = null;

if (isset($_GET['url']) && !empty($_GET['url'])) {
    $url = htmlspecialchars(trim($_GET['url']));

    $sql = "SELECT title, description, favicon FROM website WHERE url = :url";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':url' => $url));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($data) {
    echo json_encode($data);
}
?>

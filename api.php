<?php
require_once('config.php');
require_once('functions.php');
header('Content-Type: application/json');

// Get the user IP
$ip = get_ip();

// Verify permission to access the data
$sql = "SELECT nb_access, last_access FROM api WHERE user_ip = :user_ip";
$stmt = $db->prepare($sql);
$stmt->execute(array(':user_ip' => $ip));
$ip_infos = $stmt->fetch(PDO::FETCH_ASSOC);

$block = false;
// Verify if the IP is in the table
if (!empty($ip_infos)) {
    $nb_access = $ip_infos['nb_access'];
    // Check the number of access
    if ($ip_infos['nb_access'] == $max_api_access_free) {
        // Check the last access
        $seconds = time() - $ip_infos['last_access'];
        $second_in_a_day = 86400;
        if ($seconds >= $second_in_a_day) {
            // Reset the counter
            $nb_access = 0;
        }
        else {
            // Block the request
            $block = true;
        }
    }
}
else {
    // Add the user IP to the table
    $nb_access = 0;
    $sql = "INSERT INTO api (user_ip, nb_access, last_access) VALUES (:user_ip, :nb_access, UNIX_TIMESTAMP())";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_ip', $ip);
    $stmt->bindParam(':nb_access', $nb_access, PDO::PARAM_INT);
    $stmt->execute();
}

if (!$block) {
    $data = array();
    // Get the user request
    if (isset($_GET['url']) && !empty($_GET['url'])) {
        // Increment the number of access
        $nb_access += 1;
        $sql = "UPDATE api SET nb_access = :nb_access, last_access = UNIX_TIMESTAMP() WHERE user_ip = :user_ip";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nb_access', $nb_access, PDO::PARAM_INT);
        $stmt->bindParam(':user_ip', $ip);
        $stmt->execute();

        // Return data associated with the request
        $url = htmlspecialchars(trim($_GET['url']));
        $sql = "SELECT title, description, favicon FROM website WHERE url = :url";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':url' => $url));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            $data['error'] = 'Any data associated to this url';
        }
    }
    else {
        $data['error'] = 'Missing url in the request';
    }
}
else {
    $data['error'] = 'You have to wait for reusing the API or upgrade your current plan with the premium one';
}

echo json_encode($data);
?>

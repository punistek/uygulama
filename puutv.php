<?php
$token = "7426497726:AAEPDzRSsXjAvTFpN_B7bteQj00a6wacSAg";
$chat_id = "1224314188";

if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);

    $response = file_get_contents($url);
    echo $response;
} else {
    echo "no message";
}
?>

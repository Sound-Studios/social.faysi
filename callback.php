<?php
session_start();
$config = require 'auth0-config.php';

if (!isset($_GET['code'])) {
    die('Code not received from Auth0.');
}

$code = $_GET['code'];

// Tauschen Sie den Code gegen ein Zugriffstoken
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://{$config['domain']}/oauth/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'grant_type' => 'authorization_code',
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'],
        'code' => $code,
        'redirect_uri' => $config['redirect_uri']
    ]),
    CURLOPT_HTTPHEADER => [
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    die("cURL Error #:" . $err);
}

$data = json_decode($response, true);

if (!isset($data['access_token'])) {
    die('Access token not received from Auth0.');
}

$_SESSION['access_token'] = $data['access_token'];
header('Location: /index.php');
exit();
?>

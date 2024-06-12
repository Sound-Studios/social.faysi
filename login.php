<?php
$config = require 'auth0-config.php';

// URL für die Auth0-Anmeldung
$auth_url = "https://{$config['domain']}/authorize?"
    . "response_type=code&"
    . "client_id={$config['client_id']}&"
    . "redirect_uri={$config['redirect_uri']}&"
    . "scope={$config['scope']}&"
    . "audience={$config['audience']}";

// Umleiten zur Auth0-Anmeldeseite
header("Location: $auth_url");
exit();
?>

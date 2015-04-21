<?php
session_start();
 
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
 
date_default_timezone_set('America/Denver');

 
$client = new Client(['base_url' => 'https://api.twitter.com', 'defaults' => ['auth' => 'oauth']]);
 
$oauth = new Oauth1([
    'consumer_key'    => 'SylAEgIvl8zjbrl9afSDYh2zO',
    'consumer_secret' => 'goZOqwS9JXAUqbzN7FG9bIQyywX6iC2RfLf8dFWPj0n1XKshB0'
]);
 
$client->getEmitter()->attach($oauth);
 
// Set the "auth" request option to "oauth" to sign using oauth
$res = $client->post('oauth/request_token', ['body' => ['oauth_callback' => 'http://localhost/profile']]);
 
$params = (string)$res->getBody();
 
parse_str($params);
 
$_SESSION['oauth_token'] = $oauth_token;
$_SESSION['oauth_token_secret'] = $oauth_token_secret;
 
header("Location: https://api.twitter.com/oauth/authenticate?oauth_token={$oauth_token}");
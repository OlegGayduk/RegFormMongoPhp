<?php

require_once("../vendor/autoload.php");

$client = new MongoDB\Client;

$db = $client->users;

$collection = $db->users_list;

?>
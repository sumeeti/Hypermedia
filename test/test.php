<?php
/**
 * Created by PhpStorm.
 * User: sumeeti
 * Date: 22/3/16
 * Time: 9:18 PM
 */

require_once 'Client.php';
$client = new Client("https://api.github.com");
//var_dump($client->getUri());
$user = $client->users('captn3m0');
//var_dump($user);
$repos = $user->repos();
//var_dump($repos);
$repo = $repos[0];
//var_dump($repo);
$issues = $repo->issues();
//var_dump($issues);
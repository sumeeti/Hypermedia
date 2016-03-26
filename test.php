<?php
/**
 * Created by PhpStorm.
 * User: sumeeti
 * Date: 22/3/16
 * Time: 9:18 PM
 */

require_once 'src/Client.php';
require_once 'src/ClientList.php';
$client = new hyper\Client("https://api.github.com");
//var_dump($client->getUri());
$user = $client->users('mojombo');
//var_dump($user);
$repos = $user->repos();
$repos_n = $repos->next();
var_dump($repos_n);
$repo = $repos[1];
//var_dump($repo);
$issues = $repo->issues();

$issue = $issues[0];
//var_dump($issue);
$events = $issue->events();
$event = $events[0];
//var_dump($event->actor());
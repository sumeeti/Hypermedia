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
//var_dump($repos);
$repos_n = $repos->next();
//var_dump($repos_n);
$repos_p = $repos_n->prev();
//var_dump($repos_f);
$repos_l = $repos_p->last();
$repo = $repos[1];
$repos_f = $repos_l->first();
//var_dump($repos_f);
$issues = $repo->issues();

$issue = $issues[0];
//var_dump($issue);
$events = $issue->events();
//var_dump($event->actor());
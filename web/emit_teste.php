<?php
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

require __DIR__ . '/../vendor/autoload.php';

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

$version = new Version2X("http://192.168.200.10:3001");
$client = new Client($version);
$client->initialize();
$client->emit("new_order", ['test'=>'test','teste1'=>'teste1']);
$client->close();
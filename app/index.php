<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_include_path('/home/kite/workspace');
require 'predis/autoload.php';

if (isset($_GET['cmd']) === true) {
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $_ENV['SERVICE_HOST'],
      'port'   => $_ENV['REDISMASTER_SERVICE_PORT'],
    ]);
    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $read_port = $_ENV['REDISMASTER_SERVICE_PORT'];

    if (isset($_ENV['REDISMASTER_SERVICE_PORT'])) {
      $read_port = $_ENV['REDISMASTER_SERVICE_PORT'];
    }
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $_ENV['SERVICE_HOST'],
      'port'   => $read_port,
    ]);

    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>

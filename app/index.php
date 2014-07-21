<?

set_include_path('.:/usr/share/php:/usr/share/pear:/vendor/predis');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'predis/autoload.php';

if (isset($_GET['cmd']) === true) {
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => getenv('SEVEN_SERVICE_PROXY_HOST'),
      'port'   => getenv('SEVEN_SERVICE_REDIS_PORT'),
    ]);
    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $read_port = getenv('SEVEN_SERVICE_REDIS_PORT');

    if (isset($_ENV['SEVEN_SERVICE_REDIS_READ_SLAVE_PORT'])) {
      $read_port = getenv('SEVEN_SERVICE_REDIS_READ_SLAVE_PORT');
    }
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => getenv('SEVEN_SERVICE_PROXY_HOST'),
      'port'   => $read_port,
    ]);

    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>


<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

// Configuration
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
 
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '../logs/app.log',
        ],
    ],
]);

// Set up dependencies
$container = $app->getContainer();
 
// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::WARNING));
    return $logger;
};

$app->get('/', function (Request $request, Response $response) {
    $file = 'index.html';
    if (file_exists($file)) {
        return $response->write(file_get_contents($file));
    } else {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
});

// Routes
require '../src/routes/abteilungen.php';
require '../src/routes/prioritaeten.php';
require '../src/routes/tickets.php';
require '../src/routes/kategorien.php';
require '../src/routes/validierung.php';
require '../src/routes/nutzer.php';

$app->run();
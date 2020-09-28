<?php declare(strict_types=1);

use League\Route\Router;
use League\Container\Container;
use Symfony\Component\Dotenv\Dotenv;
use League\Route\Strategy\JsonStrategy;
use Zend\Diactoros\ServerRequestFactory;
use Http\Factory\Diactoros\ResponseFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Bogatyrev\controllers\QuestionController;
use Bogatyrev\repositories\CsvFilePersistance;
use Bogatyrev\repositories\JsonFilePersistance;
use Bogatyrev\repositories\PersistanceInterface;
use Bogatyrev\repositories\QuestionRepository;
use Bogatyrev\translate\DummyTranslator;
use Bogatyrev\translate\TranslatorInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

include '../vendor/autoload.php';

// Import ENVs
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Configure di container
$container = new Container;

$container->add(QuestionRepository::class)
    ->addArgument(PersistanceInterface::class)
    ->addArgument(LoggerInterface::class);

$container->add(QuestionController::class)
    ->addArgument(QuestionRepository::class)
    ->addArgument(TranslatorInterface::class);

// Add logger
$container->add(LoggerInterface::class, function() {
    $logger = new Logger('log');
    $logsDir = getenv('LOGS_DIR') === false ? __DIR__ . '/../logs' : getenv('LOGS_DIR');
    $logger->pushHandler(new StreamHandler($logsDir . '/app.log', Logger::ERROR));
    return $logger;
}, true);

// Add dummy translator
$container->add(TranslatorInterface::class, function() {
    return new DummyTranslator();
}, true);

// Add google translator
// $container->add(TranslatorInterface::class, function() {
//     return new GoogleTranslator();
// }, true);

// Add json file persistance
$container->add(PersistanceInterface::class, function() {
    $filePath = getenv('JSON_PERSISTANCE_DATA');
    $persistance = new JsonFilePersistance($filePath);
    return $persistance;
}, true);

// Add csv file persistance
// $container->add(PersistanceInterface::class, function() {
//     $filePath = getenv('CSV_PERSISTANCE_DATA');
//     $persistance = new CsvFilePersistance($filePath);
//     return $persistance;
// }, true);

$responseFactory = new ResponseFactory;
$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

/** @var League\Route\Strategy\JsonStrategy $strategy*/
$strategy = (new JsonStrategy($responseFactory))->setContainer($container);

/** @var League\Route\Router $router */
$router  = (new Router)->setStrategy($strategy);

// API
$router->map('GET', '/questions', [QuestionController::class, 'listItems']);
$router->map('POST', '/questions', [QuestionController::class, 'createItem']);

$response = $router->dispatch($request);

// send the response to the browser
(new SapiEmitter)->emit($response);

<?php

use App\Debug\Application;
use App\Debug\Middleware\DecodeGzipMiddleware;
use App\Debug\Middleware\LogMiddleware;
use App\Debug\Middleware\NoCorsMiddleware;
use App\Debug\Middleware\UrlMatcherMiddleware;
use App\Debug\Module\MonologHandler;
use App\Debug\Module\SentryHandler;
use App\Debug\Module\Smtp\SmtpCatcherHandler;
use App\Debug\Module\Smtp\SmtpPreviewHandler;
use App\Debug\Module\VarDumperHandler;
use App\Debug\Router;
use App\Debug\Websocket\Dispatcher;
use App\Debug\Websocket\Publisher;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Loop;
use React\Http\Message\Response;
use SleekDB\Store;

require __DIR__ . '/vendor/autoload.php';

$loop = Loop::get();

// Parameters
$dbPath = __DIR__.'/var/db';
$websocketHost = '0.0.0.0:8888';

// Services
$sentryStore = new Store("sentry", $dbPath, ['timeout' => false]);
$smtpStore = new Store("smtp", $dbPath, ['timeout' => false]);
$varDumperStore = new Store("var_dump", $dbPath, ['timeout' => false]);
$logStore = new Store("log", $dbPath, ['timeout' => false]);
$publisher = new Publisher($websocketHost);

// Servers
$app = new Application('0.0.0.0:8080', $loop);

$router = new Router();
$router->get('/', fn() => Response::html(file_get_contents(__DIR__ . '/public/index.html')));
$router->get('/api/sentry', fn() => Response::json($sentryStore->findAll(['_id' => 'DESC'])));
$router->get(
    '/api/sentry/(.*)',
    fn(ServerRequestInterface $request) => Response::json($sentryStore->findById($request->getAttribute('id')))
);
$router->get('/api/smtp', fn() => Response::json($smtpStore->findAll(['_id' => 'DESC'])));
$router->get('/api/smtp/preview/(.*)', new SmtpPreviewHandler($smtpStore));
$router->get(
    '/api/smtp/(.*)',
    fn(ServerRequestInterface $request) => Response::json($smtpStore->findById($request->getAttribute('id')))
);


$router->get('/api/log', fn() => Response::json($logStore->findAll(['_id' => 'DESC'])));
$router->get('/api/dump', fn() => Response::json($varDumperStore->findAll(['_id' => 'DESC'])));
$router->post('/api/(.*)/store', new SentryHandler($sentryStore, $publisher));

// Authentification
//if (isset($_ENV['USERNAME'], $_ENV['PASSWORD']) || isset($_SERVER['USERNAME'], $_SERVER['PASSWORD'])) {
//    $app->addMiddleware(new AuthentificationMiddleware(
//        $_ENV['USERNAME'] ?? $_SERVER['USERNAME'],
//        $_ENV['PASSWORD'] ?? $_SERVER['PASSWORD'],
//    ));
//}

$app
    ->addWebsocket('0.0.0.0:8888', new Dispatcher())
    ->addSocket('0.0.0.0:5555', new VarDumperHandler($varDumperStore, $publisher))
    ->addSocket('0.0.0.0:4343', new MonologHandler($logStore, $publisher))
    ->addSocket('0.0.0.0:1025', new SmtpCatcherHandler($smtpStore, $publisher))
    ->addMiddleware(
        new LogMiddleware(),
        new DecodeGzipMiddleware(),
        new NoCorsMiddleware(),
        new UrlMatcherMiddleware($router)
    );

try {
    $app->run();
} catch (\Throwable $e) {
    echo $e->getMessage().PHP_EOL;
}






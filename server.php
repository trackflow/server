<?php

declare(strict_types=1);

use App\Debug\Application;
use App\Debug\Middleware\AuthentificationMiddleware;
use App\Debug\Middleware\DecodeGzipMiddleware;
use App\Debug\Middleware\LogMiddleware;
use App\Debug\Middleware\NoCorsMiddleware;
use App\Debug\Middleware\StaticServerMiddleware;
use App\Debug\Middleware\UrlMatcherMiddleware;
use App\Debug\Module\Monolog\FileMonologRepository;
use App\Debug\Module\Monolog\MonologHandler;
use App\Debug\Module\Sentry\FileSentryRepository;
use App\Debug\Module\Sentry\SentryHandler;
use App\Debug\Module\Smtp\FileSmtpRepository;
use App\Debug\Module\Smtp\SmtpCatcherHandler;
use App\Debug\Module\Smtp\SmtpPreviewHandler;
use App\Debug\Module\VarDumper\FileVarDumperRepository;
use App\Debug\Module\VarDumper\VarDumperHandler;
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
$dbPath = sys_get_temp_dir();
$websocketHost = '0.0.0.0:8816';

// Repositories
$sentryRepository = new FileSentryRepository(new Store("sentry", $dbPath, ['timeout' => false]));
$smtpRepository = new FileSmtpRepository(new Store("smtp", $dbPath, ['timeout' => false]));
$varDumperRepository = new FileVarDumperRepository(new Store("var_dump", $dbPath, ['timeout' => false]));
$logRepository = new FileMonologRepository(new Store("log", $dbPath, ['timeout' => false]));

// Services
$publisher = new Publisher($websocketHost);

// Servers
$app = new Application('0.0.0.0:8815', $loop);

$router = new Router();
$router->get('/', fn() => Response::html(file_get_contents(__DIR__ . '/public/index.html')));
$router->get('/api/sentry', fn() => Response::json($sentryRepository->findAll(['_id' => 'DESC'])));
$router->get(
    '/api/sentry/(.*)',
    fn(ServerRequestInterface $request) => Response::json($sentryRepository->get((int) $request->getAttribute('id')))
);
$router->get('/api/smtp', fn() => Response::json($smtpRepository->findAll(['_id' => 'DESC'])));
$router->get('/api/smtp/preview/(.*)', new SmtpPreviewHandler($smtpRepository));
$router->get(
    '/api/smtp/(.*)',
    fn(ServerRequestInterface $request) => Response::json($smtpRepository->get((int) $request->getAttribute('id')))
);

$router->get('/api/log', fn() => Response::json($logRepository->findAll(['_id' => 'DESC'])));
$router->get('/api/dump', fn() => Response::json($varDumperRepository->findAll(['_id' => 'DESC'])));
$router->post('/api/(.*)/store', new SentryHandler($sentryRepository, $publisher));

// Authentication
if (isset($_ENV['USERNAME'], $_ENV['PASSWORD']) || isset($_SERVER['USERNAME'], $_SERVER['PASSWORD'])) {
    $app->addMiddleware(new AuthentificationMiddleware(
        $_ENV['USERNAME'] ?? $_SERVER['USERNAME'],
        $_ENV['PASSWORD'] ?? $_SERVER['PASSWORD'],
    ));
}

$app
    ->addWebsocket('0.0.0.0:8816', new Dispatcher())
    ->addSocket('0.0.0.0:5555', new VarDumperHandler($varDumperRepository, $publisher))
    ->addSocket('0.0.0.0:4343', new MonologHandler($logRepository, $publisher))
    ->addSocket('0.0.0.0:1025', new SmtpCatcherHandler($smtpRepository, $publisher))
    ->addMiddleware(
        new LogMiddleware(),
        new DecodeGzipMiddleware(),
        new NoCorsMiddleware(),
        new StaticServerMiddleware(__DIR__.'/public'),
        new UrlMatcherMiddleware($router)
    );

try {
    $app->run();
} catch (\Throwable $e) {
    echo $e->getMessage().PHP_EOL;
}

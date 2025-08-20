<?php

declare(strict_types=1);

use App\Contracts\{
    AuthInterface,
    RequestValidatorFactoryInterface,
    RouteNameInterface,
    SessionInterface,
};
use App\Core\{
    Auth,
    Config,
    RequestFactory,
};
use App\DataObjects\SessionConfig;
use App\Enums\SameSite;
use App\Services\MailSymfonyService;
use App\Services\RouteNamePhpRendererService;
use App\Services\SessionService;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Slim\App;
use Symfony\Component\Mailer\MailerInterface;

use function DI\create;

return [
    App::class => function (ContainerInterface $container) {
        $middleware = require CONFIG_PATH . '/middleware.php';
        $route      = require CONFIG_PATH . '/routes/web.php';

        AppFactory::setContainer($container);

        $app = AppFactory::create();

        $middleware($app);

        $route($app);

        return $app;
    },
    PhpRenderer::class                      => create(PhpRenderer::class)->constructor(VIEW_PATH),
    Config::class                           => create(Config::class)->constructor(require CONFIG_PATH . '/app.php'),
    MailerInterface::class                  => fn(Config $config): MailSymfonyService => new MailSymfonyService($config),
    ResponseFactoryInterface::class         => fn(App $app) => $app->getResponseFactory(),
    RouteNameInterface::class               => fn(ContainerInterface $container) => $container->get(RouteNamePhpRendererService::class),
    RequestValidatorFactoryInterface::class => fn(ContainerInterface $container) => $container->get(RequestFactory::class),
    AuthInterface::class                    => fn(ContainerInterface $container) => $container->get(Auth::class),
    SessionInterface::class                 => fn(Config $config) => new SessionService(
        new SessionConfig(
            $config->get('session.name'),
            $config->get('session.httponly'),
            $config->get('session.secure'),
            SameSite::tryFrom($config->get('session.sameSite'))
        )
    ),
    LoggerInterface::class                  => fn(Config $config): Logger
        => new Logger($config->get('app_name'))->pushHandler(
            new StreamHandler($config->get('log_directory'), Level::Warning)
        ),
];

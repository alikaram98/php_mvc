<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Models\User;
use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController
{
    public function __construct(
        private readonly PhpRenderer $phpRenderer,
        private readonly MailerInterface $mailer,
        private readonly Config $config,
    ) {}

    public function index(Request $request, Response $response): Response
    {
        return $this->phpRenderer->render($response, 'welcome.php');
    }

    public function sendEmail(Request $request, Response $response): Response
    {
        try {
            $message = new Email()
                ->from($this->config->get('mailer.from_user'))
                ->to('alikaramniyabadreh98@gmail.com')
                ->subject('test message for subect')
                ->text('another message');

            $this->mailer->send($message);

            return $this->phpRenderer->render($response, 'welcome.php');
        } catch (\Throwable $th) {
            exit($th->getMessage());
        }
    }
}

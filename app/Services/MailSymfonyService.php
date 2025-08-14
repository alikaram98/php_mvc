<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\DataObjects\MailerConfigFormatter;
use Symfony\Component\Mailer\{
    Transport\TransportInterface,
    Envelope,
    MailerInterface,
    Transport,
};
use Symfony\Component\Mime\RawMessage;

class MailSymfonyService implements MailerInterface
{
    private readonly TransportInterface $transport;

    public function __construct(
        private readonly Config $config
    ) {
        $mailer = $this->getInfoMail();

        $dsn             = "{$mailer->driver}://{$mailer->username}:{$mailer->password}@{$mailer->host}:{$mailer->port}";
        $this->transport = Transport::fromDsn($dsn);
    }

    public function send(RawMessage $message, ?Envelope $envelope = null): void
    {
        $this->transport->send($message);
    }

    public function getInfoMail(): MailerConfigFormatter
    {
        $info = $this->config->get('mailer');

        return new MailerConfigFormatter(
            $info['driver'],
            $info['username'],
            $info['password'],
            $info['port'],
            $info['host'],
            $info['encryption']
        );
    }
}

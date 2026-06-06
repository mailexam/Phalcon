<?php

declare(strict_types=1);

namespace App\Services;

final class MailConfig
{
    public static function smtp(): array
    {
        $login = getenv('MAILEXAM_LOGIN') ?: '';
        $port = (int) (getenv('MAILEXAM_PORT') ?: 587);
        $from = getenv('MAIL_FROM') ?: 'noreply@example.test';

        $config = [
            'driver' => 'smtp',
            'host' => $login . '.mailexam.io',
            'port' => $port,
            'username' => $login,
            'password' => getenv('MAILEXAM_PASSWORD') ?: '',
            'from' => [
                'email' => $from,
                'name' => 'Mailexam Test',
            ],
        ];

        if ($port === 465) {
            $config['encryption'] = 'ssl';
        } elseif (in_array($port, [587, 2525], true)) {
            $config['encryption'] = 'tls';
        }

        return $config;
    }
}

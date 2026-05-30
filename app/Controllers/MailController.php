<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\MailConfig;
use Phalcon\Incubator\Mailer\Manager as MailerManager;
use Phalcon\Mvc\Controller;

class MailController extends Controller
{
    public function testAction()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        $payload = $this->request->getJsonRawBody(true) ?? [];

        $to = $payload['to'] ?? 'user@example.test';
        $subject = $payload['subject'] ?? 'Phalcon + Mailexam';
        $body = $payload['body'] ?? $payload['text'] ?? 'Mailexam test from Phalcon';

        $mailer = new MailerManager(MailConfig::smtp());

        $mailer->createMessage()
            ->to($to)
            ->subject($subject)
            ->content($body)
            ->send();

        return $this->response->setJsonContent(['status' => 'ok']);
    }
}

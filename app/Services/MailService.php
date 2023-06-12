<?php

namespace Services;

class MailService
{
    protected array $headers = [];
    protected array $config = [];

    public function __construct()
    {
        $this->config = require_once "../config/mail.php";
    }

    public function send(string $to, string $subject, string $messageText): void
    {
        $this->prepareHeaders();

        try {
            mail(
                $to,
                $subject,
                $this->prepareMessage($subject, $messageText),
                $this->headers
            );
        }
        catch (\Exception $ex) {
            throw new \RuntimeException("Error happened during email sending:" . $ex->getMessage());
        }

    }

    protected function prepareHeaders(): void
    {
        $this->headers = [
            "From" => $this->config['from'],
            "Reply-To" => $this->config['reply'],
            "X-Mailer" => "PHP/" . phpversion(),
            "Content-Type" => "text/html; charset=utf-8"
        ];

    }

    protected function prepareText(string $msg): string
    {
        $msg = trim($msg);
        $msg = stripslashes($msg);
        return htmlspecialchars($msg);
    }

    protected function prepareMessage(string $subject, string $msg): string
    {
        $data = [
            'subject' => $subject,
            'message' => $this->prepareText($msg),
        ];

        extract($data);
        return require_once "../app/templates/mail.php";
    }
}


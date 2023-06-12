<?php

namespace Services;

/**
 * The MailService class handles sending emails.
 */
class MailService
{
    protected array $headers = [];
    protected array $config = [];

    /**
     * Initializes the MailService with configuration settings.
     */
    public function __construct()
    {
        $this->config = require_once "../config/mail.php";
    }

    /**
     * Send an email.
     *
     * @param string $to The recipient's email address.
     * @param string $subject The subject of the email.
     * @param string $messageText The content of the email.
     * @throws \RuntimeException if an error occurs during email sending.
     */
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
            throw new \RuntimeException("Error happened during email sending: " . $ex->getMessage());
        }
    }

    /**
     * Prepare the email headers.
     */
    protected function prepareHeaders(): void
    {
        $this->headers = [
            "From" => $this->config['from'],
            "Reply-To" => $this->config['reply'],
            "X-Mailer" => "PHP/" . phpversion(),
            "Content-Type" => "text/html; charset=utf-8"
        ];
    }

    /**
     * Prepare the message content.
     *
     * @param string $subject The subject of the email.
     * @param string $msg The message content.
     * @return string The prepared message content.
     */
    protected function prepareMessage(string $subject, string $msg): string
    {
        $data = [
            'subject' => $subject,
            'message' => $this->prepareText($msg),
        ];

        extract($data);
        return require_once "../app/templates/mail.php";
    }

    /**
     * Prepare the text by trimming, removing slashes, and escaping special characters.
     *
     * @param string $msg The text to prepare.
     * @return string The prepared text.
     */
    protected function prepareText(string $msg): string
    {
        $msg = trim($msg);
        $msg = stripslashes($msg);
        return htmlspecialchars($msg);
    }
}

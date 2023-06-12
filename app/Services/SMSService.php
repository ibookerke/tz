<?php

namespace Services;

use PDO;

/**
 * The SMSService class handles sending SMS messages.
 */
class SMSService {
    protected PDO $connection;
    private array $config;

    /**
     * Initializes the SMSService with configuration settings and establishes a database connection.
     */
    public function __construct() {
        $this->config = require_once "../config/sms.php";
        $this->prepareConnection();
    }

    /**
     * Establishes a database connection using the configured settings.
     */
    protected function prepareConnection(): void
    {
        $this->connection = new \PDO("smtp:{$this->config['host']}:{$this->config['port']}", $this->config['username'], $this->config['password']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Prepares a PDO statement for sending an SMS message.
     *
     * @param string $phone The recipient's phone number.
     * @param string $message The content of the SMS message.
     * @return \PDOStatement|false The prepared PDO statement or false on failure.
     */
    protected function prepareStatement(string $phone, string $message) : \PDOStatement|false
    {
        return $this->connection->prepare("
            MAIL FROM:{$this->config['username']}
            RCPT TO:{$phone}
            DATA
            {$message}
            .
        ");
    }

    /**
     * Sends an SMS message.
     *
     * @param string $phone The recipient's phone number.
     * @param string $message The content of the SMS message.
     * @throws \RuntimeException if an error occurs during SMS sending.
     */
    public function send(string $phone, string $message): void
    {
        try {
            $stmt = $this->prepareStatement($phone, $message);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error sending SMS: {$e->getMessage()}");
        }
    }
}

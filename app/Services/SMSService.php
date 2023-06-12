<?php

namespace Services;

use PDO;

class SMSService {
    protected PDO $connection;
    private array $config;

    public function __construct() {
        $this->config = require_once "../config/sms.php";
        $this->prepareConnection();
    }

    protected function prepareConnection(): void
    {
        $this->connection = new \PDO("smtp:{$this->config['host']}:{$this->config['port']}", $this->config['username'], $this->config['password']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

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
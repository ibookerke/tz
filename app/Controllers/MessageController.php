<?php

namespace Controllers;

use Core\http\Controller;
use Models\Message;
use Services\MailService;
use Services\SMSService;

/**
 * The MessageController class handles the logic for managing messages.
 */
class MessageController extends Controller
{

    /**
     * Display the index page with a list of all messages.
     */
    public function index(): void
    {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        $msg = new Message();
        $messages = $msg->all();

        $this->view('messages.index', [
            'messages' => $messages
        ]);
    }

    /**
     * Display the create message form.
     */
    public function create(): void
    {
        $this->view('messages.create');
    }

    /**
     * Store a new message in the database and send it via email and SMS.
     */
    public function store(): void
    {
        $request_data = $this->request->all();
        $message = $request_data['msg'];

        $msg = new Message();
        $msg->insert([
            'message' => $message
        ]);

        $mail = new MailService();
        $mail->send("some_email", "Email Subject", $message);

        $sms = new SMSService();
        $sms->send("8717271727", $message);

        redirect('');
    }
}

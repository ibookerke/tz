<?php

namespace Controllers;

use Core\http\Controller;
use Models\Message;
use Services\MailService;
use Services\SMSService;

class MessageController extends Controller
{

    public function index()
    {
        $msg = new Message();
        $messages = $msg->all();

        $this->view('messages.index', [
            'messages' => $messages
        ]);

    }

    public function create()
    {
        $this->view('messages.create');
    }

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
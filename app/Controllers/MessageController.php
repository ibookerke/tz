<?php

namespace Controllers;

use Core\Controller;
use Models\Message;

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
        $request_data = $this->getPostData();

        $message = $request_data['msg'];

        $msg = new Message();
        $msg->insert([
            'message' => $message
        ]);

        redirect('');
    }

}
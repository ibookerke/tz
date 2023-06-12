<?php

namespace Core\http;

class Controller
{
    public Request $request;
    public function __construct()
    {
        $this->request = new Request();
    }

    public function view($view, $data = []) : void
    {
        $view = str_replace('.', '/', $view);

        $filename = "../app/Views/".$view.".view.php";

        if(!file_exists($filename)) {
            $filename = "../app/Views/404.view.php";
        }

        if(!empty($data)) {
            extract($data);
        }

        require $filename;
    }

}
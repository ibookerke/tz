<?php

namespace Core;

class Controller
{
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

    protected function getPostData()
    {
        $pairs = explode("&", file_get_contents("php://input"));
        $vars = array();
        foreach ($pairs as $pair) {
            $nv = explode("=", $pair);
            $name = urldecode($nv[0]);
            $value = urldecode($nv[1]);
            $vars[$name] = $value;
        }
        return $vars;
    }

}
<?php

function abort(int $err_code = 500, string|null $msg = '', string|null $err = ''): void
{
    if(empty($msg)) {
        $msg = match ($err_code) {
            400 => 'Bad Request',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            default => 'Server Error'
        };
    }

    $data = [
        'code' => $err_code,
        'msg' => $msg,
        'err' => $err
    ];

    extract($data);
    require "../app/Views/error.view.php";
}
function redirect($path): void
{
    header("Location: http://localhost/".$path);
    die;
}
<?php

/**
 * Abort the execution and display an error page.
 *
 * @param int $err_code The HTTP error code (default: 500).
 * @param string|null $msg The error message to display (default: null).
 * @param string|null $err Additional error information (default: null).
 * @return void
 */
function abort(int $err_code = 500, string|null $msg = '', string|null $err = ''): void
{
    if (empty($msg)) {
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

/**
 * Redirect the user to a different page.
 *
 * @param string $path The path or URL to redirect to.
 * @return void
 */
function redirect(string $path): void
{
    header("Location: http://localhost/" . $path);
    die;
}

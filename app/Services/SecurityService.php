<?php

namespace Services;

Class SecurityService
{

    public static function CSRFValid(string $token) : bool
    {
        if (!$token || $token !== $_SESSION['token']) {
            return false;
        }

        return true;
    }

    public static function getEscapedString(string $str): string
    {
        return strip_tags(htmlspecialchars($str));
    }


}
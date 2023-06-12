<?php

namespace Services;

/**
 * The SecurityService class provides security-related helper functions.
 */
class SecurityService
{
    /**
     * Validate a CSRF token.
     *
     * @param string $token The CSRF token to validate.
     * @return bool Returns true if the CSRF token is valid, false otherwise.
     */
    public static function CSRFValid(string $token): bool
    {
        if (!$token || $token !== $_SESSION['token']) {
            return false;
        }

        return true;
    }

    /**
     * Escape a string to prevent HTML and SQL injection vulnerabilities.
     *
     * @param string $str The string to escape.
     * @return string The escaped string.
     */
    public static function getEscapedString(string $str): string
    {
        return strip_tags(htmlspecialchars($str));
    }
}

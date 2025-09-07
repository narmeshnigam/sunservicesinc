<?php
/**
 * Helper functions used throughout the site
 */

/**
 * Sanitize a string for safe output in HTML.
 * @param string|null $str
 * @return string
 */
function e(?string $str): string
{
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a specified path and exit.
 * @param string $path
 */
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

/**
 * Generate a random token (for CSRF etc.)
 * @param int $length
 * @return string
 */
function random_token(int $length = 32): string
{
    return bin2hex(random_bytes($length));
}
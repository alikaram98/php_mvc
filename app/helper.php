<?php

use App\Enums\UserAuth;

if (!function_exists('showError')) {
    function showError(?array $error = null)
    {
        if (!is_null($error)) {
            $message = implode(',', $error);
            echo "<span class='error-message' id='emailError'>$message</span>";
        }
    }
}

if (!function_exists('keyAuth')) {
    function keyAuth(): string
    {
        return UserAuth::Key->value;
    }
}

if (!function_exists('html')) {
    function html($text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

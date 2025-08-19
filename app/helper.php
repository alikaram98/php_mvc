<?php

if (!function_exists('showError')) {
    function showError(?array $error = null)
    {
        if (!is_null($error)) {
            $message = implode(',', $error);
            echo "<span class='error-message' id='emailError'>$message</span>";
        }
    }
}

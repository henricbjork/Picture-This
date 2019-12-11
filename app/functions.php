<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}
// This function echoes errors when they occur
// and then removes the message on reload.
function displayError()
{
    echo $_SESSION['errors'][0];
    unset($_SESSION['errors']);
}

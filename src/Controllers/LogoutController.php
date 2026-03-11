<?php
class LogoutController {
    public static function handle() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        header('Location: /?page=login');
        exit;
    }
}

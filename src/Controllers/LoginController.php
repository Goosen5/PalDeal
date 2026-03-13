<?php
require_once BASE_PATH . '/src/Database.php';

class LoginController
{
    public static function handle()
    {
        $errors  = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$username || !$password) {
                $errors[] = 'All fields are required.';
            } else {
                $user = Database::fetchOne('SELECT * FROM users WHERE username = :username', [':username' => $username]);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'email'    => $user['email'],
                        'is_admin' => $user['is_admin'],
                    ];
                    $success = true;
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            }
        }

        return ['errors' => $errors, 'success' => $success];
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    public static function getUser()
    {
        return $_SESSION['user'] ?? null;
    }
}

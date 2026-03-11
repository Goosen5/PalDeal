<?php
require_once BASE_PATH . '/src/Database.php';

class RegisterController
{
    public static function handle()
    {
        $errors  = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username         = trim($_POST['username'] ?? '');
            $email            = trim($_POST['email'] ?? '');
            $password         = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (!$username || !$email || !$password || !$confirm_password) {
                $errors[] = 'All fields are required.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address.';
            }
            if ($password !== $confirm_password) {
                $errors[] = 'Passwords do not match.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }

            if (empty($errors)) {
                $taken = (int) Database::fetchValue(
                    'SELECT COUNT(*) FROM users WHERE username = :username OR email = :email',
                    [':username' => $username, ':email' => $email]
                );

                if ($taken > 0) {
                    $errors[] = 'Username or email already exists.';
                } else {
                    Database::execute(
                        'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)',
                        [':username' => $username, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT)]
                    );
                    $success = true;
                }
            }
        }

        return ['errors' => $errors, 'success' => $success];
    }
}

<?php
class LoginController {
    public static function handle() {
        // session_start(); // Already started in config.php
        $errors = [];
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            if (!$username || !$password) {
                $errors[] = 'All fields are required.';
            } else {
                $db = new PDO('sqlite:' . __DIR__ . '/../../database/paldeals.db');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
                $stmt->execute([':username' => $username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'is_admin' => $user['is_admin']
                    ];
                    $success = true;
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            }
        }
        return ['errors' => $errors, 'success' => $success];
    }
    public static function isLoggedIn() {
        // session_start(); // Already started in config.php
        return isset($_SESSION['user']);
    }
    public static function getUser() {
        // session_start(); // Already started in config.php
        return $_SESSION['user'] ?? null;
    }
}

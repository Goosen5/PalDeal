<?php
class RegisterController {
    public static function handle() {
        $errors = [];
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Basic validation
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

            // If no errors, proceed
            if (empty($errors)) {
                $db = new PDO('sqlite:' . __DIR__ . '/../../database/paldeals.db');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Check for existing user
                $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = :username OR email = :email');
                $stmt->execute([':username' => $username, ':email' => $email]);
                if ($stmt->fetchColumn() > 0) {
                    $errors[] = 'Username or email already exists.';
                } else {
                    // Hash password
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                    $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hash]);
                    $success = true;
                }
            }
        }
        return ['errors' => $errors, 'success' => $success];
    }
}

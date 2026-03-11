<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PalDeals</title>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div class="main-panel">
        <div class="login-window">
            <h2>Login</h2>
            <?php if (isset($errors) && count($errors) > 0): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($success) && $success): ?>
                <div class="success-message">
                    <p style="color: green;">Login successful! Redirecting...</p>
                </div>
            <?php endif; ?>
            <form method="POST" action="/?page=login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="register-link">
                <span>Don't have an account?</span>
                <a href="/?page=register">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>

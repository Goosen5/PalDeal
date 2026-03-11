<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - PalDeals</title>
    <link rel="stylesheet" href="/assets/css/register.css">
</head>
<body>
    <div class="main-panel">
        <div class="register-window">
            <h2>Create your account</h2>
            <?php if (!empty($errors)) { ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error) { ?>
                        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if (!empty($success)) { ?>
                <div class="success-message">
                    <p style="color:green;">Registration successful! You can now <a href="/?page=login">login</a>.</p>
                </div>
            <?php } else { ?>
            <form action="/?page=register" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <?php } ?>
            <div class="switch-auth">
                <span>Already have an account?</span>
                <a href="/?page=login">Login here</a>
            </div>
        </div>
    </div>
</body>
</html>

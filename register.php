<?php
require_once __DIR__.'/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordCookie = isValidUsername($username) ? passwordCookieName($username) : '';

    if ($passwordCookie === '' || !is_string($password) || $password === '') {
        $error = 'Use a username of 1-40 letters or numbers and enter a password.';
    } elseif (isset($_COOKIE[$passwordCookie])) {
        $error = 'That username is already registered.';
    } else {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            if (!setcookie($passwordCookie, $passwordHash, time() + 31536000, '/')) {
                throw new RuntimeException('Could not save this account in the browser.');
            }
            $_COOKIE[$passwordCookie] = $passwordHash;
            logInAccount($username);
            $_SESSION['currentPage'] = 'character.php';
            header('Location: character.php');
            exit;
        } catch (RuntimeException $exception) {
            $error = $exception->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Create an Account</h1>
    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <fieldset>
            <label>Username <input type="text" name="username" required></label>
            <label>Password <input type="password" name="password" required></label>
        </fieldset>
        <button type="submit">Register</button>
    </form>
    <p><a href="login.php">Back to login</a></p>
</body>
</html>
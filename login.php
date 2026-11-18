<?php
require_once __DIR__.'/auth.php';

$activeUsername = $_COOKIE['rpgUser'] ?? '';
if (isValidUsername($activeUsername)
    && isset($_COOKIE[passwordCookieName($activeUsername)])) {
    startAccountSession($activeUsername);
    if (($_SESSION['user'] ?? '') === $activeUsername) {
        header('Location: ' . getResumePage($_SESSION));
        exit;
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordCookie = isValidUsername($username) ? passwordCookieName($username) : '';

    if ($passwordCookie !== '' && isset($_COOKIE[$passwordCookie])
        && is_string($_COOKIE[$passwordCookie]) && is_string($password)
        && password_verify($password, $_COOKIE[$passwordCookie])) {
        try {
            logInAccount($username);
            header('Location: '.getResumePage($_SESSION));
            exit;
        } catch (RuntimeException $exception) {
            $error = $exception->getMessage();
        }
    } else {
        $error = 'Username or password is incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['msg'])): ?>
        <p><?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <fieldset>
            <label>Username <input type="text" name="username" required></label>
            <label>Password <input type="password" name="password" required></label>
        </fieldset>
        <button type="submit">Log in</button>
    </form>
    <p><a href="register.php">Create an account</a></p>
</body>
</html>

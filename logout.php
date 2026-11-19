<?php
require_once __DIR__ . '/auth.php';
requireLogin(false);
session_write_close();
setcookie('rpgUser', '', time() - 42000, '/');
unset($_COOKIE['rpgUser']);

header('Location: login.php?msg=' . urlencode('You have been logged out.'));
exit;
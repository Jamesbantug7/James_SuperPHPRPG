<?php
function isValidUsername($username)
{
    return is_string($username) && preg_match('/^[a-zA-Z0-9]{1,40}$/', $username) === 1;
}

function passwordCookieName($username)
{
    return 'rpgPassword_'.strtolower($username);
}

function startAccountSession($username)
{
    $name = 'RPG'.strtolower($username);
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (session_name() === $name) {
            return true;
        }
        session_write_close();
    }

    session_name($name);
    session_set_cookie_params(31536000, '/');
    ini_set('session.gc_maxlifetime', '31536000');
    if (!session_start()) {
        throw new RuntimeException('Could not start the account session.');
    }

    return true;
}

function logInAccount($username)
{
    startAccountSession($username);
    if (!session_regenerate_id(true)) {
        throw new RuntimeException('Could not start the account session.');
    }

    $_SESSION['user'] = $username;
    if (!setcookie('rpgUser', $username, time() + 31536000, '/')) {
        throw new RuntimeException('Could not remember the logged-in account in this browser.');
    }
    $_COOKIE['rpgUser'] = $username;
}

function requireLogin($saveCurrentPage = true)
{
    $username = $_COOKIE['rpgUser'] ?? '';

    if (!isValidUsername($username) || !isset($_COOKIE[passwordCookieName($username)]) 
        || !startAccountSession($username) || ($_SESSION['user'] ?? '') !== $username) {
        header('Location: login.php');
        exit;
    }

    if ($saveCurrentPage) {
        $_SESSION['currentPage'] = basename($_SERVER['PHP_SELF']);
    }
}

function getResumePage($game)
{
    $pages = [
        'character.php', 'story.php', 'story2.php', 'story3.php',
        'story4.php', 'battle.php', 'ending.php',
    ];
    $page = $game['currentPage'] ?? 'character.php';

    return in_array($page, $pages, true) ? $page : 'character.php';
}
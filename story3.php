<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$option2 = $_POST['storyChoice2'] ?? '';
$option1 = $_POST['storyChoice1'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chapter 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Third part of story: The wizard tells <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> that they were trying to find the treasure themselves in order to destroy it. They then explain how the treasure grants the user the ability to grant any one of their wishes, but that could be very deadly. They beg <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> to help destroy the treasure.</h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle3">
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <input type="hidden" name="storyChoice2" value="<?= htmlspecialchars($option2) ?>">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice3" value="choice1" required>Listen to the wizard and agree to help.</label>
        <label><input type="radio" name="storyChoice3" value="choice2" required>Ignore the wizard and continue your journey.</label>
        <label><input type="radio" name="storyChoice3" value="choice3" required>Kill the wizard.</label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
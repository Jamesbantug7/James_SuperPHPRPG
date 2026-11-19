<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$option1 = $_POST['storyChoice1'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chapter 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Second part of story: <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> then wanders through a cave and sees an animal hiding in the corner. You notice the animal is in pain.</h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle2">
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice2" value="choice1" required>Help the animal.</label>
        <label><input type="radio" name="storyChoice2" value="choice2" required>Ignore it.</label>
        <label><input type="radio" name="storyChoice2" value="choice3" required>Kill and eat.</label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
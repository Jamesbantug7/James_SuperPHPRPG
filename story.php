<?php
require_once __DIR__.'/auth.php';
requireLogin();
if (!isset($_SESSION['playerClass'], $_SESSION['playerRace'])) {
    $_SESSION['currentPage'] = 'character.php';
    header('Location: character.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chapter 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>
    Beginning of story: <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> finds themselves walking through the forest searching for a mysterious treasure guarded by the land's dragon. 
    There, they came across an old merchant looking for help carrying his items.
</h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle1">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice1" value="choice1" required>Help the merchant.</label>
        <label><input type="radio" name="storyChoice1" value="choice2" required>Ignore the merchant.</label>
        <label><input type="radio" name="storyChoice1" value="choice3" required>Kill the merchant and take his gold.</label>
    </fieldset>
    
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
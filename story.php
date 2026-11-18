<?php
require_once __DIR__ . '/auth.php';
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
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Placeholder</title>
</head>
<body>
<h1>Beginning of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle1">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice1" value="choice1" required>Choice 1 placeholder</label>
        <label><input type="radio" name="storyChoice1" value="choice2" required>Choice 2 placeholder</label>
        <label><input type="radio" name="storyChoice1" value="choice3" required>Choice 3 placeholder</label>
    </fieldset>

    
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>


<?php
require_once __DIR__.'/auth.php';
requireLogin();
$option3 = $_POST['storyChoice3'] ?? '';
$option1 = $_POST['storyChoice1'] ?? '';
$option2 = $_POST['storyChoice2'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chapter 4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>
    Climax of story: <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> After fighting the dragon, <?= htmlspecialchars($_SESSION['playerName'] ?? 'Hero'); ?> sees the treasure on the ground.
</h1>
<form action="ending.php" method="post">   
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <input type="hidden" name="storyChoice2" value="<?= htmlspecialchars($option2) ?>">
    <input type="hidden" name="storyChoice3" value="<?= htmlspecialchars($option3) ?>">
    <fieldset>
        <legend>What would your wish be if you use the treasure?</legend>
        <label><input type="radio" name="storyChoice4" value="choice1" required>Wish for peace for the land.</label>
        <label><input type="radio" name="storyChoice4" value="choice2" required>Wish for wealth for yourself.</label>
        <label><input type="radio" name="storyChoice4" value="choice3" required>Take over the land with power.</label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
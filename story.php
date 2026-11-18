<?php
session_start();
if (!isset($_SESSION['playerClass'], $_SESSION['playerRace'])) {
    header('Location: character.php');
    exit;
}
if (!isset($_SESSION['selectedChoices'])) {
    $_SESSION['selectedChoices'] = [];
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
    <label for="storyChoices">
        What will you do?
    </label>
    <legend>
        <input type="radio" name="storyChoice1" value="choice1">Choice 1 placeholder</input>
        <input type="radio" name="storyChoice1" value="choice2">Choice 2 placeholder</input>
        <input type="radio" name="storyChoice1" value="choice3">Choice 3 placeholder</input>
    </legend>
    <button type="submit">Submit</button>
</form>
</body>
</html>


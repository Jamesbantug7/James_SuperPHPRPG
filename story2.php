<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$option1 = $_POST['storyChoice1'] ?? '';
$options = [
    'choice1' => ['Good Choice', 'eh Choice', 'trash Choice'],
    'choice2' => ['Bad Choice', 'whatever Choice', 'decent Choice'],
    'choice3' => ['Bad Choice', 'mediocre Choice', 'test Choice'],
];
$option2 = $options[$option1] ?? ['Default Choice', 'Default Choice', 'Default Choice'];
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
<h1>Second part of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle2">
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice2" value="choice1" required><?= htmlspecialchars($option2[0]) ?></label>
        <label><input type="radio" name="storyChoice2" value="choice2" required><?= htmlspecialchars($option2[1]) ?></label>
        <label><input type="radio" name="storyChoice2" value="choice3" required><?= htmlspecialchars($option2[2]) ?></label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
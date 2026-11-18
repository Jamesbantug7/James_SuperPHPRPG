<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$option2 = $_POST['storyChoice2'] ?? '';
$option1 = $_POST['storyChoice1'] ?? '';
$options = [
    'choice1' => ['Good Choice', 'eh Choice', 'trash Choice'],
    'choice2' => ['Bad Choice', 'whatever Choice', 'decent Choice'],
    'choice3' => ['Bad Choice', 'mediocre Choice', 'test Choice'],
];
$option3 = $options[$option2] ?? ['Default Choice', 'Default Choice', 'Default Choice'];
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
<h1>Third part of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle3">
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <input type="hidden" name="storyChoice2" value="<?= htmlspecialchars($option2) ?>">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice3" value="choice1" required><?= htmlspecialchars($option3[0]) ?></label>
        <label><input type="radio" name="storyChoice3" value="choice2" required><?= htmlspecialchars($option3[1]) ?></label>
        <label><input type="radio" name="storyChoice3" value="choice3" required><?= htmlspecialchars($option3[2]) ?></label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
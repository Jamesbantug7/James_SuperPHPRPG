<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$option3 = $_POST['storyChoice3'] ?? '';
$option1 = $_POST['storyChoice1'] ?? '';
$option2 = $_POST['storyChoice2'] ?? '';
$options = [
    'choice1' => ['Good Choice', 'eh Choice', 'trash Choice'],
    'choice2' => ['Bad Choice', 'whatever Choice', 'decent Choice'],
    'choice3' => ['Bad Choice', 'mediocre Choice', 'test Choice'],
];
$option4 = $options[$option3] ?? ['Default Choice', 'Default Choice', 'Default Choice'];
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
<h1>Climax of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="ending.php" method="post">   
    <input type="hidden" name="storyChoice1" value="<?= htmlspecialchars($option1) ?>">
    <input type="hidden" name="storyChoice2" value="<?= htmlspecialchars($option2) ?>">
    <input type="hidden" name="storyChoice3" value="<?= htmlspecialchars($option3) ?>">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice4" value="choice1" required><?= htmlspecialchars($option4[0]) ?></label>
        <label><input type="radio" name="storyChoice4" value="choice2" required><?= htmlspecialchars($option4[1]) ?></label>
        <label><input type="radio" name="storyChoice4" value="choice3" required><?= htmlspecialchars($option4[2]) ?></label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
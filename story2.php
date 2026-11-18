<?php
session_start();
if (!isset($_SESSION['selectedChoices'])) {
    $_SESSION['selectedChoices'] = [];
}
$option1 = $_POST['storyChoice1'] ?? '';
if ($option1 !== '') {
    $_SESSION['selectedChoices'][] = $option1;
}
$option2_1 = "Default Choice";
$option2_2 = "Default Choice";
$option2_3 = "Default Choice";
if ($option1 == "choice1") {
    $option2_1 = "Good Choice";
    $option2_2 = "eh Choice";
    $option2_3 = "trash Choice";
}
if ($option1 == "choice2") {
    $option2_1 = "Bad Choice";
    $option2_2 = "whatever Choice";
    $option2_3 = "decent Choice";
}
if ($option1 == "choice3") {
    $option2_1 = "Bad Choice";
    $option2_2 = "mediocre Choice";
    $option2_3 = "test Choice";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Placeholder</title>
</head>
<body>
<h1>Second part of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="battle.php" method="post">
    <input type="hidden" name="battle" value="battle2">
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice2" value="choice1" required><?= htmlspecialchars($option2_1) ?></label>
        <label><input type="radio" name="storyChoice2" value="choice2" required><?= htmlspecialchars($option2_2) ?></label>
        <label><input type="radio" name="storyChoice2" value="choice3" required><?= htmlspecialchars($option2_3) ?></label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
</body>
</html>

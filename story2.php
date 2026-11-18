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
    <meta charset="UTF-8">
    <title>Placeholder</title>
</head>
<body>
<h1>Second part of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="https://codd.cs.gsu.edu/~jbantug1/WP/PW/2/story3.php" method="post">    
    <label for="storyChoices">
        What will you do?
    </label>
    <legend>
        <input type="radio" name="storyChoice2" value="choice1"><?= htmlspecialchars($option2_1) ?></input>
        <input type="radio" name="storyChoice2" value="choice2"><?= htmlspecialchars($option2_2) ?></input>
        <input type="radio" name="storyChoice2" value="choice3"><?= htmlspecialchars($option2_3) ?></input>
    </legend>
    <button type="submit">Submit</button>
</form>
</body>
</html>

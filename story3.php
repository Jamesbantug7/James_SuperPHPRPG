<?php
session_start();
if (!isset($_SESSION['selectedChoices'])) {
    $_SESSION['selectedChoices'] = [];
}
$option2 = $_POST['storyChoice2'] ?? '';
if ($option2 !== '') {
    $_SESSION['selectedChoices'][] = $option2;
}
$option3_1 = "Default Choice";
$option3_2 = "Default Choice";
$option3_3 = "Default Choice";
if ($option2 == "choice1") {
    $option3_1 = "Good Choice";
    $option3_2 = "eh Choice";
    $option3_3 = "trash Choice";
}
if ($option2 == "choice2") {
    $option3_1 = "Bad Choice";
    $option3_2 = "whatever Choice";
    $option3_3 = "decent Choice";
}
if ($option2 == "choice3") {
    $option3_1 = "Bad Choice";
    $option3_2 = "mediocre Choice";
    $option3_3 = "test Choice";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Placeholder</title>
</head>
<body>
<h1>Third part of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="https://codd.cs.gsu.edu/~jbantug1/WP/PW/2/story4.php" method="post">    
    <label for="storyChoices">
        What will you do?
    </label>
    <legend>
        <input type="radio" name="storyChoice3" value="choice1"><?= htmlspecialchars($option3_1) ?></input>
        <input type="radio" name="storyChoice3" value="choice2"><?= htmlspecialchars($option3_2) ?></input>
        <input type="radio" name="storyChoice3" value="choice3"><?= htmlspecialchars($option3_3) ?></input>
    </legend>
    <button type="submit">Submit</button>
</form>
</body>
</html>

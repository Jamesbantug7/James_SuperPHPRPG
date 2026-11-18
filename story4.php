<?php
session_start();
if (!isset($_SESSION['selectedChoices'])) {
    $_SESSION['selectedChoices'] = [];
}
$option3 = $_POST['storyChoice3'] ?? '';
if ($option3 !== '') {
    $_SESSION['selectedChoices'][] = $option3;
}
$option4_1 = "Default Choice";
$option4_2 = "Default Choice";
$option4_3 = "Default Choice";
if ($option3 == "choice1") {
    $option4_1 = "Good Choice";
    $option4_2 = "eh Choice";
    $option4_3 = "trash Choice";
}
if ($option3 == "choice2") {
    $option4_1 = "Bad Choice";
    $option4_2 = "whatever Choice";
    $option4_3 = "decent Choice";
}
if ($option3 == "choice3") {
    $option4_1 = "Bad Choice";
    $option4_2 = "mediocre Choice";
    $option4_3 = "test Choice";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Placeholder</title>
</head>
<body>
<h1>Climax of story: The heroes are blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah </h1>
<form action="ending.php" method="post">   
    <fieldset>
        <legend>What will you do?</legend>
        <label><input type="radio" name="storyChoice4" value="choice1" required><?= htmlspecialchars($option4_1) ?></label>
        <label><input type="radio" name="storyChoice4" value="choice2" required><?= htmlspecialchars($option4_2) ?></label>
        <label><input type="radio" name="storyChoice4" value="choice3" required><?= htmlspecialchars($option4_3) ?></label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
</body>
</html>

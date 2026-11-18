<?php
session_start();

$classes = ['fighter', 'mage', 'knight'];
$races = ['human', 'elf', 'dwarf'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['classChoice'] ?? '';
    $race = $_POST['raceChoice'] ?? '';

    if (in_array($class, $classes, true) && in_array($race, $races, true)) {
        $_SESSION['playerClass'] = $class;
        $_SESSION['playerRace'] = $race;
        unset($_SESSION['battlePlayer'], $_SESSION['currentBattle'], $_SESSION['selectedChoices']);
        header('Location: story.php');
        exit;
    }

    $error = 'Choose a class and race to continue.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Placeholder</title>
</head>
<body>
<h1>Character Selection</h1>
<?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form action="character.php" method="post">
    <fieldset>
        <legend>Choose your class</legend>
        <label><input type="radio" name="classChoice" value="fighter" required> Fighter</label>
        <label><input type="radio" name="classChoice" value="mage"> Mage</label>
        <label><input type="radio" name="classChoice" value="knight"> Knight</label>
    </fieldset>
    <fieldset>
        <legend>Choose your race</legend>
        <label><input type="radio" name="raceChoice" value="human" required> Human</label>
        <label><input type="radio" name="raceChoice" value="elf"> Elf</label>
        <label><input type="radio" name="raceChoice" value="dwarf"> Dwarf</label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
</body>
</html>
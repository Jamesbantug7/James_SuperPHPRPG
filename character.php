<?php
require_once __DIR__ . '/auth.php';
requireLogin();

$classes = ['fighter', 'mage', 'knight'];
$races = ['human', 'elf', 'dwarf'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['playerName'] ?? '';
    $class = $_POST['classChoice'] ?? '';
    $race = $_POST['raceChoice'] ?? '';

    if (trim($name) !== '' && in_array($class, $classes, true) && in_array($race, $races, true)) {
        $_SESSION['playerName'] = trim($name);
        $_SESSION['playerClass'] = $class;
        $_SESSION['playerRace'] = $race;
        unset(
            $_SESSION['battlePlayer'],
            $_SESSION['currentBattle'],
            $_SESSION['ending'],
            $_SESSION['leaderboard_entry_index']
        );
        $_SESSION['currentPage'] = 'story.php';
        header('Location: story.php');
        exit;
    }

    $error = 'Choose a name, class, and race to continue.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Character Selection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Character Selection</h1>
<?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form action="character.php" method="post">
    <label>Name: <input type="text" name="playerName" required></label>
    <fieldset>
        <legend>Choose your class</legend>
        <label><input type="radio" name="classChoice" value="fighter" required>Fighter</label>
        <label><input type="radio" name="classChoice" value="mage">Mage</label>
        <label><input type="radio" name="classChoice" value="knight">Knight</label>
    </fieldset>
    <fieldset>
        <legend>Choose your race</legend>
        <label><input type="radio" name="raceChoice" value="human" required>Human</label>
        <label><input type="radio" name="raceChoice" value="elf">Elf</label>
        <label><input type="radio" name="raceChoice" value="dwarf">Dwarf</label>
    </fieldset>
    <button type="submit">Submit</button>
</form>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
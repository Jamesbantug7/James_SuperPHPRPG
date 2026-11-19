<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$titles = [
    'good' => 'Good Ending',
    'normal' => 'Normal Ending',
    'evil' => 'Evil Ending',
    'secret' => 'Secret Path',
];

if (($_POST['action'] ?? '') === 'replay') {
    unset(
        $_SESSION['ending'],
        $_SESSION['leaderboard_entry_index'],
        $_SESSION['battlePlayer'],
        $_SESSION['currentBattle']
    );
    $_SESSION['currentPage'] = 'character.php';
    header('Location: character.php');
    exit;
}

$choices = [];
$choiceTypes = ['choice1' => 'good', 'choice2' => 'normal', 'choice3' => 'evil'];
foreach (range(1, 4) as $chapter) {
    $choice = $_POST['storyChoice' . $chapter] ?? '';
    if (!is_string($choice) || !isset($choiceTypes[$choice])) {
        header('Location: story.php');
        exit;
    }
    $choices[] = $choiceTypes[$choice];
}

$counts = array_count_values($choices);
foreach (['good', 'normal', 'evil'] as $type) {
    $counts[$type] = $counts[$type] ?? 0;
}
$end = 'normal';
if ($counts['good'] > $counts['normal'] && $counts['good'] > $counts['evil']) {
    $end = 'good';
} elseif ($counts['evil'] > $counts['good'] && $counts['evil'] > $counts['normal']) {
    $end = 'evil';
}
$_SESSION['ending'] = $end;

$playerName = trim((string)($_SESSION['playerName'] ?? $_SESSION['user'] ?? ''));
$playerName = $playerName !== '' ? $playerName : 'The hero';
$endingMessages = [
    'good' => $playerName.' destroys the treasure so nobody could ever use it for selfishness.',
    'normal' => $playerName.' keeps the treasure for themselves in case there would ever be a need to use it.',
    'evil' => $playerName.' uses the treasure on the spot to grant their wish, which may have negative consequences for themselves and the world in the future...',
];

$entry = [
    'user' => $_SESSION['user'],
    'ending' => $end,
    'choices' => $counts,
];
$_SESSION['leaderboard'] ??= [];
$entryIndex = $_SESSION['leaderboard_entry_index'] ?? null;
if (!is_int($entryIndex) || !isset($_SESSION['leaderboard'][$entryIndex])) {
    $entryIndex = null;
    for ($i = count($_SESSION['leaderboard']) - 1; $i >= 0; $i--) {
        $savedEntry = $_SESSION['leaderboard'][$i];
        if (($savedEntry['user'] ?? '') === $_SESSION['user']) {
            $entryIndex = $i;
            break;
        }
    }
}
if ($entryIndex === null) {
    $_SESSION['leaderboard'][] = $entry;
    $entryIndex = count($_SESSION['leaderboard']) - 1;
} else {
    $_SESSION['leaderboard'][$entryIndex] = $entry;
}
$_SESSION['leaderboard_entry_index'] = $entryIndex;
$rows = $_SESSION['leaderboard'];
usort($rows, function ($a, $b) {
    $aChoices = $a['choices'] ?? [];
    $bChoices = $b['choices'] ?? [];
    $good = ($bChoices['good'] ?? 0) <=> ($aChoices['good'] ?? 0);
    if ($good !== 0) {
        return $good;
    }
    return ($bChoices['normal'] ?? 0) <=> ($aChoices['normal'] ?? 0);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ending</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1><?= htmlspecialchars($titles[$end]) ?></h1>
  <p><?= htmlspecialchars($endingMessages[$end]) ?></p>
  <p>Choices: Good <?= $counts['good'] ?>, Normal <?= $counts['normal'] ?>, Evil <?= $counts['evil'] ?></p>

  <h2>Leaderboard</h2>
  <table>
    <tr><th>#</th><th>Player</th><th>Good</th><th>Normal</th><th>Evil</th><th>Ending</th></tr>
    <?php foreach ($rows as $i => $r): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($r['user']) ?></td>
        <td><?= (int)($r['choices']['good'] ?? 0) ?></td>
        <td><?= (int)($r['choices']['normal'] ?? 0) ?></td>
        <td><?= (int)($r['choices']['evil'] ?? 0) ?></td>
        <td><?= htmlspecialchars($titles[$r['ending']] ?? 'Previous Ending') ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <form method="post"><button name="action" value="replay">Play Again</button></form>
  <p><a href="logout.php">Log out</a></p>
</body>
</html>
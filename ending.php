<?php
require_once __DIR__ . '/auth.php';
requireLogin();
$titles = ['good' => 'Good Ending', 'bad' => 'Bad Ending', 'secret' => 'Secret Path'];

if (($_POST['storyChoice4'] ?? '') === 'choice1') {
    $_SESSION['ending'] = 'good';
} elseif (($_POST['storyChoice4'] ?? '') === 'choice2') {
    $_SESSION['ending'] = 'bad';
} elseif (($_POST['storyChoice4'] ?? '') === 'choice3') {
    $_SESSION['ending'] = 'secret';
}

$end = $_SESSION['ending'] ?? '';
if (!isset($titles[$end])) {
    header('Location: story.php');
    exit;
}

if (($_POST['action'] ?? '') === 'replay') {
    unset($_SESSION['ending'], $_SESSION['score_saved'], $_SESSION['score'], $_SESSION['battlePlayer'], $_SESSION['currentBattle']);
    $_SESSION['currentPage'] = 'character.php';
    header('Location: character.php');
    exit;
}

$score = (int)($_SESSION['score'] ?? 0);
if (empty($_SESSION['score_saved'])) {
    $_SESSION['leaderboard'] ??= [];
    $_SESSION['leaderboard'][] = ['user' => $_SESSION['user'], 'score' => $score, 'ending' => $end];
    $_SESSION['score_saved'] = true;
}
$rows = $_SESSION['leaderboard'];
usort($rows, fn($a, $b) => $b['score'] <=> $a['score']);
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
  <p>Score: <?= $score ?></p>

  <h2>Leaderboard</h2>
  <table>
    <tr><th>#</th><th>Player</th><th>Score</th><th>Ending</th></tr>
    <?php foreach ($rows as $i => $r): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($r['user']) ?></td>
        <td><?= (int)$r['score'] ?></td>
        <td><?= htmlspecialchars($titles[$r['ending']]) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <form method="post"><button name="action" value="replay">Play Again</button></form>
  <p><a href="logout.php">Log out</a></p>
</body>
</html>
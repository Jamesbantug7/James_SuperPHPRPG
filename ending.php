<?php
session_start();

if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
$titles = ['heroic' => 'Heroic Victory', 'tragic' => 'Tragic Failure', 'secret' => 'Secret Path'];
$end = $_SESSION['ending'] ?? '';
if (!isset($titles[$end])) { header('Location: story.php'); exit; }

if (($_POST['action'] ?? '') === 'replay') {
    unset($_SESSION['hero'], $_SESSION['node'], $_SESSION['ending'], $_SESSION['score_saved']);
    header('Location: character.php'); exit;
}

$score = (int)($_SESSION['score'] ?? 0);
if (empty($_SESSION['score_saved'])) {
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
<style>
  body { font-family: Georgia, serif; background: #14121a; color: #eee; text-align: center; padding: 20px; }
  h1 { animation: fade 2s ease-in; }
  @keyframes fade { from { opacity: 0; } to { opacity: 1; } }
  table { margin: 0 auto; border-collapse: collapse; }
  td, th { padding: 6px 14px; border-bottom: 1px solid #444; }
</style>
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
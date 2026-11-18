<?php
require_once __DIR__ . '/auth.php';
requireLogin();

$battles = [
    'battle1' => [
        'name' => 'Placeholder Enemy 1',
        'hp' => 40,
        'attack' => 14,
        'defense' => 5,
        'magicAttack' => 12,
        'magicDefense' => 7,
        'moves' => ['attack', 'magic'],
        'next' => 'story2.php',
    ],
    'battle2' => [
        'name' => 'Placeholder Enemy 2',
        'hp' => 60,
        'attack' => 15,
        'defense' => 9,
        'magicAttack' => 16,
        'magicDefense' => 10,
        'moves' => ['attack', 'magic'],
        'next' => 'story3.php',
    ],
    'battle3' => [
        'name' => 'Placeholder Enemy 3',
        'hp' => 80,
        'attack' => 18,
        'defense' => 13,
        'magicAttack' => 20,
        'magicDefense' => 14,
        'moves' => ['attack', 'magic'],
        'next' => 'story4.php',
    ],
];

$classStats = [
    'fighter' => ['hp' => 70, 'attack' => 15, 'defense' => 9, 'magicDefense' => 8, 'magicPower' => 3],
    'mage' => ['hp' => 50, 'attack' => 8, 'defense' => 7, 'magicDefense' => 13, 'magicPower' => 18],
    'knight' => ['hp' => 90, 'attack' => 13, 'defense' => 12, 'magicDefense' => 12, 'magicPower' => 8],
];
$raceModifiers = [
    'human' => ['hp' => 0, 'attack' => 0, 'defense' => 0, 'magicDefense' => 0, 'magicPower' => 0],
    'elf' => ['hp' => -10, 'attack' => 3, 'defense' => -4, 'magicDefense' => 1, 'magicPower' => 4],
    'dwarf' => ['hp' => 10, 'attack' => -2, 'defense' => 5, 'magicDefense' => 4, 'magicPower' => -2],
];
if (!empty(trim($_POST['playerName'] ?? ''))) {
    $_SESSION['playerName'] = trim($_POST['playerName']);
}

$playerName = $_SESSION['playerName'] ?? 'Hero';
$playerClass = $_SESSION['playerClass'] ?? 'fighter';
$playerRace = $_SESSION['playerRace'] ?? 'human';

if (!isset($classStats[$playerClass])) {
    $playerClass = 'fighter';
}
if (!isset($raceModifiers[$playerRace])) {
    $playerRace = 'human';
}
$playerDefaults = $classStats[$playerClass];
foreach ($raceModifiers[$playerRace] as $stat => $modifier) {
    $playerDefaults[$stat] += $modifier;
}
$playerDefaults['hp'] = max(1, $playerDefaults['hp']);
$playerDefaults['magicPower'] = max(1, $playerDefaults['magicPower']);
$playerDefaults['maxHp'] = $playerDefaults['hp'];
$playerDefaults['items'] = 1;
$playerDefaults['name'] = $playerName;
$playerDefaults['class'] = $playerClass;
$playerDefaults['race'] = $playerRace;

$battleId = $_POST['battle'] ?? ($_SESSION['currentBattle']['id'] ?? '');
if (!isset($battles[$battleId])) {
    http_response_code(400);
    exit('Unknown battle.');
}

if (!isset($_SESSION['battlePlayer']['magicPower'])) {
    $_SESSION['battlePlayer'] = $playerDefaults;
}

$storyData = [];
foreach (['storyChoice1', 'storyChoice2', 'storyChoice3', 'storyChoice4'] as $field) {
    $value = $_POST[$field] ?? '';
    if (in_array($value, ['choice1', 'choice2', 'choice3'], true)) {
        $storyData[$field] = $value;
    }
}

if (($_POST['restart'] ?? '') === '1') {
    $_SESSION['battlePlayer'] = $playerDefaults;
    unset($_SESSION['currentBattle']);
}

if (!isset($_SESSION['currentBattle']) || $_SESSION['currentBattle']['id'] !== $battleId) {
    $_SESSION['currentBattle'] = [
        'id' => $battleId,
        'enemyHp' => $battles[$battleId]['hp'],
        'status' => 'active',
        'storyData' => $storyData,
        'lastMove' => '',
    ];
} elseif ($storyData) {
    $_SESSION['currentBattle']['storyData'] = $storyData;
}
if (!isset($_SESSION['currentBattle']['lastMove'])) {
    $_SESSION['currentBattle']['lastMove'] = '';
}
if (!isset($_SESSION['currentBattle']['storyData'])) {
    $_SESSION['currentBattle']['storyData'] = [];
}

$error = '';
$action = $_POST['action'] ?? '';
$player =& $_SESSION['battlePlayer'];
$battle =& $_SESSION['currentBattle'];

if ($action !== '' && $battle['status'] === 'active') {
    $damage = 0;
    $actionMessage = '';
    if ($action === 'attack') {
        $damage = max(1, $player['attack'] + random_int(0, 5) - ($battles[$battleId]['defense']*0.7));
        $actionMessage = 'You dealt ' . $damage . ' damage.';
    } 
    elseif ($action === 'magic') {
        $damage = max(1, (int)round($player['magicPower'] * 1.25) + random_int(4, 7) - ($battles[$battleId]['magicDefense']*0.7));
        $actionMessage = 'You dealt ' . $damage . ' magic damage.';
    } 
    elseif ($action === 'item') {
        if ($player['items'] < 1) {
            $error = 'You are out of items.';
        } 
        else {
            $player['items']--; 
            $oldHp = $player['hp'];
            $player['hp'] += 30;
            if ($player['hp'] > $playerDefaults['hp']) {
                $player['hp'] = $playerDefaults['hp']; 
            }
            $healed = $player['hp'] - $oldHp;
            $actionMessage = 'You restored ' . $healed . ' HP.';
        }
    } 
    else {
        $error = 'Choose Attack, Magic, or Item.';
    }

    if ($error === '') {
        $battle['enemyHp'] = max(0, $battle['enemyHp'] - $damage);
        $battle['lastMove'] = $actionMessage;
        if ($battle['enemyHp'] === 0) {
            $battle['status'] = 'won';
            $player['items'] += 1;
            $_SESSION['score'] = ($_SESSION['score'] ?? 0) + 100;
        } 
        else {
            $move = $battles[$battleId]['moves'][array_rand($battles[$battleId]['moves'])];
            $enemyAttack = $move === 'magic'
                ? $battles[$battleId]['magicAttack']
                : $battles[$battleId]['attack'];
            $playerDefense = $move === 'magic'
                ? $player['magicDefense']
                : $player['defense'];
            $incomingDamage = max(1, $enemyAttack - ($playerDefense*0.7));
            $player['hp'] = max(0, $player['hp'] - $incomingDamage);
            $battle['lastMove'] .= ' ' . $battles[$battleId]['name'] . ' used ' . ucfirst($move)
                . ' and dealt ' . $incomingDamage . ' damage.';
            if ($player['hp'] === 0) {
                $battle['status'] = 'lost';
            }
        }
    }
}

$player = $_SESSION['battlePlayer'];
$battle = $_SESSION['currentBattle'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Battle: <?= htmlspecialchars($battles[$battleId]['name']) ?></title>
</head>
<body>
    <h1>Battle: <?= htmlspecialchars($battles[$battleId]['name']) ?></h1>
    <section>
        <h2><?= htmlspecialchars($player['name'] ?? $playerName) ?></h2>
        <p><?= htmlspecialchars(ucfirst($player['race']) . ' ' . ucfirst($player['class'])) ?></p>
        <p>HP: <?= (int)$player['hp'] ?> / <?= (int)$player['maxHp'] ?> |
            Items: <?= (int)$player['items'] ?></p>
        <p>Attack: <?= (int)$player['attack'] ?> |
            Defense: <?= (int)$player['defense'] ?> |
            Magic Defense: <?= (int)$player['magicDefense'] ?> |
            Magic Power: <?= (int)$player['magicPower'] ?></p>
        <h2><?= htmlspecialchars($battles[$battleId]['name']) ?></h2>
        <p>Enemy HP: <?= (int)$battle['enemyHp'] ?> / <?= (int)$battles[$battleId]['hp'] ?></p>
        <p>Enemy Attack: <?= (int)$battles[$battleId]['attack'] ?> |
            Defense: <?= (int)$battles[$battleId]['defense'] ?> |
            Magic Attack: <?= (int)$battles[$battleId]['magicAttack'] ?> |
            Magic Defense: <?= (int)$battles[$battleId]['magicDefense'] ?></p>
    </section>

    <?php if ($battle['lastMove'] !== ''): ?>
        <p><?= htmlspecialchars($battle['lastMove']) ?></p>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($battle['status'] === 'active'): ?>
        <?php if ($player['items'] === 0): ?>
            <p>You are out of items. You will get another item after this story section.</p>
        <?php endif; ?>
        <form method="post" action="battle.php">
            <input type="hidden" name="battle" value="<?= htmlspecialchars($battleId) ?>">
            <?php foreach ($battle['storyData'] as $field => $value): ?>
                <input type="hidden" name="<?= htmlspecialchars($field) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>
            <button type="submit" name="action" value="attack">Attack</button>
            <button type="submit" name="action" value="magic">Magic</button>
            <button type="submit" name="action" value="item" <?= $player['items'] === 0 ? 'disabled' : '' ?>>Item</button>
        </form>
    <?php elseif ($battle['status'] === 'won'): ?>
        <h2>Victory!</h2>
        <p>You gained another item!</p>
        <form method="post" action="<?= htmlspecialchars($battles[$battleId]['next']) ?>">
            <?php foreach ($battle['storyData'] as $field => $value): ?>
                <input type="hidden" name="<?= htmlspecialchars($field) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>
            <button type="submit">Continue</button>
        </form>
    <?php else: ?>
        <h2>Game Over</h2>
        <form method="post" action="battle.php">
            <input type="hidden" name="battle" value="<?= htmlspecialchars($battleId) ?>">
            <input type="hidden" name="restart" value="1">
            <?php foreach ($battle['storyData'] as $field => $value): ?>
                <input type="hidden" name="<?= htmlspecialchars($field) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>
            <button type="submit">Try Again</button>
        </form>
    <?php endif; ?>
    <p><a href="logout.php">Log out</a></p>
</body>
</html>

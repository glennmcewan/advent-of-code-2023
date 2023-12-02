<?php

// Part 1
$handle = fopen(__DIR__ . '/../resources/day2.txt', 'r');

if (!$handle) {
    var_dump('Could not open day 2 resource file.');
    exit;
}

function getGameInfo(string $gameData): array
{
    // Quick n dirty...
    [$gameId, $sets] = explode(':', $gameData);
    $gameId = (int) preg_replace('/[^0-9]/', '', $gameId);
    $sets = array_map('trim', explode(';', $sets));

    $limits = [];

    foreach ($sets as $set) {
        $instances = explode(', ', $set);

        foreach ($instances as $instance) {
            [$quantity, $colour] = explode(' ', $instance);

            if ($quantity > ($limits[$colour] ?? 0)) {
                $limits[$colour] = (int) $quantity;
            }
        }
    }

    return compact('gameId', 'limits');
}

function isGamePossible(array $gameInfo): bool
{
    $constraints = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    foreach ($constraints as $colour => $maximum) {
        if (($gameInfo['limits'][$colour] ?? 0) > $constraints[$colour]) {
            return false;
        }
    }

    return true;
}

$gameIds = [];

while (($gameData = fgets($handle)) !== false) {
    $gameInfo = getGameInfo($gameData);

    if (isGamePossible($gameInfo)) {
        $gameIds[] = $gameInfo['gameId'];
    }
}

var_dump('Sum of Game IDs: ' . array_sum($gameIds));

// Part 2
rewind($handle);

$sumOfPowers = 0;

while (($gameData = fgets($handle)) !== false) {
    $sumOfPowers += array_product(getGameInfo($gameData)['limits']);
}

var_dump('Sum of powers for minimum balls required: ' . $sumOfPowers);

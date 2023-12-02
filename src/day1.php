<?php

// Part 1
$handle = fopen(__DIR__ . '/../resources/day1.txt', 'r');

if (!$handle) {
    var_dump('Could not open day 1 resource file.');
    exit;
}

$total = 0;

function findFirstAndLastNum(string $line): array
{
    preg_match('[0-9]', $line, $firstMatches);
    preg_match('[0-9]', strrev($line), $lastMatches);

    return [$firstMatches[1] ?? null, $lastMatches[1] ?? null];
}

while (($line = fgets($handle)) !== false) {
    [$firstInt, $lastInt] = findFirstAndLastNum($line);

    $total += (int) ($firstInt . $lastInt);
}

var_dump('Part 1 total: ' . $total);

// Part 2
$cardinals = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

$total2 = 0;

rewind($handle);

while (($line = fgets($handle)) !== false) {
    [$firstInt, $lastInt] = findFirstAndLastNum($line);

    $firstCardinal = null;
    $lastCardinal = null;

    $firstIntPos = $firstInt ? strpos($line, $firstInt) : null;
    $lastIntPos = $lastInt ? strrpos($line, $lastInt) : null;

    $firstCardinalPos = null;
    $lastCardinalPos = null;

    foreach ($cardinals as $cardinal => $numericValue) {
        $currentFirstCardinalPos = strpos($line, $cardinal);
        $currentLastCardinalPos = strrpos($line, $cardinal);

        if ($currentFirstCardinalPos !== false && ($firstCardinalPos === null || $currentFirstCardinalPos < $firstCardinalPos)) {
            $firstCardinalPos = $currentFirstCardinalPos;
            $firstCardinal = $numericValue;
        }

        if ($currentLastCardinalPos !== false && ($lastCardinalPos === null || $currentLastCardinalPos > $lastCardinalPos)) {
            $lastCardinalPos = $currentLastCardinalPos;
            $lastCardinal = $numericValue;
        }
    }

    $lineTotal = (($firstIntPos ?? 9999) < ($firstCardinalPos ?? 9999) ? $firstInt : $firstCardinal) . (($lastIntPos ?? -9999) > ($lastCardinalPos ?? -9999) ? $lastInt : $lastCardinal);
    $total2 += (int) $lineTotal;
}

var_dump('Part 2 total: ' . $total2);

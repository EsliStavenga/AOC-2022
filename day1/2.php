<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadInputForDay();
$elves = [[]];

foreach(explode(PHP_EOL, $data) as $elfData) {
  if(empty($elfData)) {
    $elves[] = [];
  } else {
    $elves[count($elves) - 1][] = (int) $elfData;
  }
}

$elfSums = array_map('array_sum', $elves);

sort($elfSums);

echo array_sum(array_slice(array_reverse($elfSums), 0, 3));


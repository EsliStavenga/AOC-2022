<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadLinesForDay();
$prioritySum = 0;

foreach($data as $backpack) {
  if(!$backpack) {
    continue;
  }

  $halves = str_split($backpack, strlen($backpack) / 2);
  $halves = array_map('str_split', $halves);

  $overlap = array_intersect(...$halves);
  $letter = reset($overlap);

  if(strtolower($letter) === $letter) {
    $prioritySum += ord($letter) - 96;
  } else {
    $prioritySum += ord($letter) - 38;
  }
}

echo $prioritySum;

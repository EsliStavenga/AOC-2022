<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadLinesForDay();
$prioritySum = 0;

for($i = 0, $max = count($data) - 1; $i < $max; $i+=3) {
  $group = array_slice($data, $i, 3);
  $backpacks = array_map('str_split', $group);

  $overlap = array_intersect(...$backpacks);
  $letter = reset($overlap);

  if(strtolower($letter) === $letter) {
    $prioritySum += ord($letter) - 96;
  } else {
    $prioritySum += ord($letter) - 38;
  }
}

echo $prioritySum;

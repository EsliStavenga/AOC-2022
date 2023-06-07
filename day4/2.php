<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadLinesForDay();
$pairs = 0;

foreach($data as $line) {
  $elfPair = array_map(function(string $range): array {
    $elfRange = explode('-', $range);
    $range = range($elfRange[0], $elfRange[1]);

    if(count($range) === 1) {
      $range[] = $range[0];
    }

    return $range;
  }, explode(',', $line));

  usort($elfPair, function(array $a, array $b): int {
    if($a[0] < $b[0] || end($a) > end($b)) {
      return -1;
    }

    return 1;
  });

  if(count(array_intersect(...$elfPair)) > 0) {
    $pairs++;
  }
}

echo $pairs;
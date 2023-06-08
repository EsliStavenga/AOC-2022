<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadLinesForDay();
$stacks = [];

while(($line = array_shift($data)) !== '') {
  preg_match_all('/( {3}|\[([A-Z])]) ?/', $line, $matches);

  foreach($matches[2] as $stack => $match) {
    if(!empty($match)) {
      $stacks[$stack+1] ??= [];
      array_unshift($stacks[$stack+1], $match);
    }
  }
}

ksort($stacks);
foreach($data as $moves) {
  preg_match_all('/\d+/', $moves, $digits);
  $digits = reset($digits);

  if(!isset($digits[0])) {
    continue;
  }

  $tmp = [];
  for($i = 0; $i < (int) $digits[0]; $i++) {
    $tmp[] = array_pop($stacks[(int) $digits[1]]);
  }

  array_push($stacks[(int) $digits[2]], ...array_reverse($tmp));
}

echo implode('', array_map(fn(array $stack) => end($stack), $stacks));

<?php

require_once('../shared/InputManager.php');
require_once('Move.php');

// 8933
$data = (new InputManager())->loadLinesForDay();

$score = 0;

foreach($data as $play) {
  /** @var Move[] $moves */
  $moves = array_map('Move::fromValue', explode(' ', $play));
  $score += $moves[1]->getScore();
  $score += $moves[1]->calculatePlayOff($moves[0]);
}

echo $score;

<?php

require_once('../shared/InputManager.php');
require_once('Move.php');

$data = (new InputManager())->loadInputForDay();

$score = 0;

foreach(explode(PHP_EOL, $data) as $play) {
  /** @var Move[] $moves */
  $moves = array_map('Move::fromValue', explode(' ', $play));
  $opponentMove = $moves[0];

  switch($moves[1]) {
    case Move::ROCK:
      $responseMove = $opponentMove->getLosingMove();
      break;
    case Move::PAPER:
      $responseMove = $opponentMove;
      break;
    case Move::SCISSOR:
      $responseMove = $opponentMove->getWinningMove();
      break;
  }

  $score += $responseMove->getScore();
  $score += $responseMove->calculatePlayOff($opponentMove);
}

echo $score;
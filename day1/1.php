<?php

const ENV = 'real';

$data = file_get_contents("../input/".ENV."/day1.input");
$elves = [[]];

foreach(explode(PHP_EOL, $data) as $elfData) {
  if(empty($elfData)) {
    $elves[] = [];
  } else {
    $elves[count($elves) - 1][] = (int) $elfData;
  }
}

$elfSums = array_map('array_sum', $elves);

echo max($elfSums);


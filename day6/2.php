<?php

require_once('../shared/InputManager.php');

$data = (new InputManager())->loadLinesForDay()[0];
$sequenceLength = 14; // haha i knew it that's why i added this variable

for($i = 0, $max = strlen($data) - $sequenceLength; $i <= $max; $i++) {
  $sequence = substr($data, $i, $sequenceLength);
  $chars = str_split($sequence);

  if(count(array_unique($chars)) === $sequenceLength) {
    echo $i + $sequenceLength;
    break;
  }
}

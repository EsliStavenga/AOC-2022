<?php

class InputManager
{

  public function __construct()
  {
  }

  public function loadInputForDay(string $env = 'real'): string
  {
    $wd = basename($_SERVER['PWD']);

    return file_get_contents(__DIR__ . "/../input/$env/$wd.input");
  }

  public function loadLinesForDay(string $env = 'real'): array
  {
    return explode(PHP_EOL, $this->loadInputForDay($env));
  }
}

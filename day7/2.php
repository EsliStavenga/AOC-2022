<?php

require_once('../shared/InputManager.php');
require_once('../shared/Computer.php');

const COMPUTER_DISK_SPACE = 70000000;
const SPACE_REQUIRED = 30000000;

$lines = (new InputManager())->loadLinesForDay();
$lines = array_filter($lines);
$computer = new Computer();

for($i = 0, $max = count($lines); $i < $max; $i++) {
  $line = $lines[$i];
  if(str_starts_with($line, '$')) {
    $command = explode(' ', $line);
    $executable = $command[1];
    $inputLines = [];

    while(isset($lines[++$i]) && !str_starts_with(($nextLine = $lines[$i]), '$')) {
      $inputLines[] = $nextLine;
    }
    $i--;

    if(!method_exists($computer, $executable)) {
      throw new BadMethodCallException($executable . ' was not found on computer :(');
    }

    $computer->{$executable}($command[2] ?? $inputLines);
  }
}

$diskSpaceInUse = $computer->getDirectorySize();
$spaceRequired = SPACE_REQUIRED - (COMPUTER_DISK_SPACE - $diskSpaceInUse);

$directories = getDirectoriesWithMaxSize($computer->filesystem, $computer);
echo min($directories);

function getDirectoriesWithMaxSize(array $directory, Computer $computer, array $path = []): array
{
  global $spaceRequired;
  $directorySizes = [];

  foreach($directory as $name => $files) {
    $tmpPath = [...$path, $name];

    if(is_array($files)) {
      array_push($directorySizes, ...getDirectoriesWithMaxSize($files, $computer, $tmpPath));

      $size = $computer->getDirectorySize($tmpPath);
      if($size >= $spaceRequired) {
        $directorySizes[] = $size;
      }
    }
  }

  return $directorySizes;
}

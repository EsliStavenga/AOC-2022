<?php

class Computer
{
  public array $filesystem = [];

  public function __construct(
    private string $pwd = '/'
  )
  {
  }

  public function mkdir(string $dir): self
  {
    $cwd = &$this->getFilesInPwd();
    $cwd[$dir] = [];

    return $this;
  }

  public function ls(array $list): self
  {
    foreach($list as $entry) {
      $command = explode(' ', $entry);

      if($command[0] === 'dir') {
        $this->mkdir($command[1]);
      } else {
        $this->touch($command[1], $command[0]);
      }
    }

    return $this;
  }

  public function touch(string $file, int $filesize): self
  {
    $cwd = &$this->getFilesInPwd();
    $cwd[$file] = $filesize;

    return $this;
  }

  public function cd(string $dir): self
  {
    if($dir === '/') {
      $this->pwd = '/';
    } else if($dir === '..') {
      $path = explode('/', rtrim($this->pwd, '/'));
      array_pop($path);
      $this->pwd = implode('/', $path) . '/';
    } else {
      $this->pwd .= "$dir/";
    }

    return $this;
  }

  private function &getFilesInPwd(): array
  {
    $files = &$this->filesystem;

    foreach(explode('/', rtrim($this->pwd, '/')) as $dir) {
      if($dir) {
        $files = &$files[$dir];
      }
    }

    return $files;
  }

  /**
   * @param string|array $path The path to the directory either as a string or as an array
   * @return int
   */
  public function getDirectorySize(string|array $path = '/'): int
  {
    $size = 0;
    // todo fix this
    if(!str_ends_with($path, '/')) {
      $path .= '/';
    }

    if(is_string($path)) {
      $files = $this->getFilesInDirectory($path);
    } else {
      return $this->getDirectorySize('/' . implode('/', $path));
    }

    foreach($files as $dirName => $file) {
      if(is_array($file)) {
        $size += $this->getDirectorySize("$path$dirName/");
      } else {
        $size += $file;
      }
    }

    return $size;
  }

  private function &getFilesInDirectory(string $path = '/'): array
  {
    $list = &$this->filesystem;

    foreach(explode('/', rtrim($path, '/')) as $dir) {
      if($dir) {
        $list = &$list[$dir];
      }
    }

    return $list;
  }

}

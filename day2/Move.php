<?php

enum Move: int
{

  case ROCK = -1;
  case PAPER = 0;
  case SCISSOR = 1;

  /**
   * Calculates the result in a play off against another move
   * 0 = lose
   * 3 = draw
   * 6 = win
   *
   * @param Move $move
   * @return int
   */
  public function calculatePlayOff(Move $move): int
  {
    if($move->value === $this->value) {
      return 3;
    }

    $moveValue = $move->toValue($this);
    $thisValue = $this->toValue($move);

    if($thisValue > $moveValue) {
      return 6;
    }

    return 0;
  }

  /**
   * Get the move that would win against this move
   *
   * @return Move
   */
  public function getWinningMove(): Move
  {
    return $this->findMoveWithScore(6);
  }

  /**
   * Get the move that would lose against this move
   *
   * @return Move
   */
  public function getLosingMove(): Move
  {
    return $this->findMoveWithScore(0);
  }

  /**
   * Returns the value of the enum, except when an opponentmove has been provided
   * If the opponentmove has been provided, and we are playing rock and they're playing scissor, we've got the upper hand so return a higer score
   *
   * @param Move|null $opponentMove
   * @return int
   */
  private function toValue(?Move $opponentMove): int
  {
    if($opponentMove && $this === self::ROCK && $opponentMove === self::SCISSOR) {
      return 2;
    }

    return $this->value;
  }

  public static function fromValue(string $value): self
  {
    if(ord($value) > 87) {
      return self::fromResponse($value);
    }

    return self::fromOpponent($value);
  }

  public static function fromOpponent(string $move): self
  {
    return self::from(ord($move) - 66);
  }

  public static function fromResponse(string $move): self
  {
    // Z = 90, -23 = 67 = C
    $move = chr(ord($move) - 23);

    return self::fromOpponent($move);
  }

  /**
   * Get the points that this score is worth
   *
   * @return int
   */
  public function getScore(): int
  {
    return match($this) {
      self::ROCK => 1,
      self::PAPER => 2,
      self::SCISSOR => 3
    };
  }

  /**
   * Finds a move against this move that yields the given score
   *
   * @param int $score
   * @return Move
   */
  private function findMoveWithScore(int $score): Move
  {

    foreach(self::cases() as $case) {
      if($case->calculatePlayOff($this) === $score) {
        return $case;
      }
    }

    throw new LogicException('Heh');
  }
}
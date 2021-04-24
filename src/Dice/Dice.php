<?php

declare(strict_types=1);

namespace Jess19\Dice;

/**
 * Class Dice.
 */

class Dice
{
    private int $value;
    private int $sides;

    /**
     * Constructor to create a Dice.
     *
     * @param int   $sides  The number of sides of the die.
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->value = 0;
    }

    /**
     * Roll the die.
     *
     * @return int as the value of the die.
     */
    public function roll(): int
    {
        $this->value = rand(1, $this->sides);
        return $this->value;
    }

    /**
     * Get the value of the last roll of the die.
     *
     * @return int as the value of the die.
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

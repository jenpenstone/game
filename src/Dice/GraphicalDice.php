<?php

declare(strict_types=1);

namespace Jess19\Dice;

/**
 * Class GraphicalDice.
 */

class GraphicalDice extends Dice
{
    /**
     * @var integer SIDES Number of sides of the Dice.
     */
    const SIDES = 6;

    /**
     * Constructor to initiate the dice with six number of sides.
     */
    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    /**
     * Get theImage adress of the last roll of the die.
     *
     * @return string with the adress of the image.
     */
    public function getImage(): string
    {
        return "dice-" . $this->getValue();
    }

}

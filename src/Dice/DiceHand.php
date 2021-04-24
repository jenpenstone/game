<?php

declare(strict_types=1);

namespace Jess19\Dice;

/**
 * Class DiceHand.
 */

class DiceHand
{
    private array $dice;
    private int $sum;

    /**
     * Constructor to create a Dice.
     *
     * @param int   $nbrDice  The number of Graphical dice to use for the hand.
     */
    public function __construct(int $nbrDice)
    {
        $this->dice = [];
        $this->sum = 0;

        for ($i = 0; $i < $nbrDice; $i++) {
            $this->dice[$i] = new GraphicalDice();
        }
    }

    /**
     * Roll the dice.
     *
     */
    public function roll(): void
    {
        $this->sum = 0;
        $length = count($this->dice);
        for ($i = 0; $i < $length; $i++) {
            $this->dice[$i]->roll();
            $this->sum += $this->dice[$i]->getValue();
        }
    }

    /**
     * Get the value of the last roll of the dice.
     *
     * @return array as the value of the die.
     */
    public function getValues(): array
    {
        $values = array();
        $length = count($this->dice);
        for ($i = 0; $i < $length; $i++) {
            $values[$i] = $this->dice[$i]->getValue();
        }
        return $values;
    }

    /**
     * Get the sum of the last roll of the dice.
     *
     * @return int sum of the hand of dice.
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * Get the value of the last roll of the dice.
     *
     * @return array as the value of the die.
     */
    public function getImages(): array
    {
        $images = array();
        $length = count($this->dice);
        for ($i = 0; $i < $length; $i++) {
            $images[$i] = $this->dice[$i]->getImage();
        }
        return $images;
    }
}

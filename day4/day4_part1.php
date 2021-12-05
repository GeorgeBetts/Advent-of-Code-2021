<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$bingo = new Bingo($values);
$numbers = $bingo->getNumbers();
foreach ($numbers as $number) {
    $winningCard = $bingo->callNumber($number);
    if ($winningCard) {
        echo $winningCard->getScore();
        break;
    }
}

class Bingo
{

    private $numbers;
    private $cards;

    public function __construct($values)
    {
        // The first line of the input provides the numbers
        $this->numbers = explode(',', $values[0]);

        // remove the first two keys from the values
        foreach (range(0, 1) as $key) {
            unset($values[$key]);
        }

        // reset the array keys
        $values = array_values($values);

        // build the cards
        foreach ($values as $key => $value) {
            if (!isset($cardVals) || isset($cardVals) && $cardVals == null) {
                $cardVals = [];
            }
            if ($value) {
                $cardVals[] = $value;
            }
            if (!$value || $key == count($values) - 1) {
                // this is the end of a card
                $this->cards[] = new Card($cardVals);
                $cardVals = null;
            }
        }
    }

    public function getNumbers()
    {
        return $this->numbers;
    }

    public function callNumber($number)
    {
        foreach ($this->cards as $card) {
            $matched = $card->checkNumber($number);
            if ($matched && $card->winningNumber != null) {
                return $card;
            }
        }
        return false;
    }
}

class Card
{

    /**
     * Lists the potential matches in a card to win
     * Each value is an array of keys for a row or column
     * in the card
     */
    const WINNING_MATCHES = [[0, 1, 2, 3, 4], [5, 6, 7, 8, 9], [10, 11, 12, 13, 14], [15, 16, 17, 18, 19], [20, 21, 22, 23, 24], [0, 5, 10, 15, 20], [1, 6, 11, 16, 21], [2, 7, 12, 17, 22], [3, 8, 13, 18, 23], [4, 9, 14, 19, 24]];

    public $grid = [];
    public $winningNumber = null;

    public function __construct($values)
    {
        // each line in the values represents a row on the grid
        foreach ($values as $value) {
            foreach (explode(' ', $value) as $number) {
                if ($number !== '') {
                    $this->grid[] = ['value' => intval($number), 'marked' => false];
                }
            }
        }
    }

    /**
     * Checks whether a number matches and will set the winning number if the called
     * number makes this card win
     *
     * @param [type] $number
     * @return void
     */
    public function checkNumber($number)
    {
        foreach ($this->grid as &$item) {
            if ($item['value'] == $number) {
                $item['marked'] = true;
                if ($this->checkWin()) {
                    $this->winningNumber = $number;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Checks the win condition of the card.
     * A card is a winning card one any row or column
     * of the grid is marked.
     *
     * @return void
     */
    private function checkWin()
    {
        foreach ($this::WINNING_MATCHES as $keys) {
            foreach ($keys as $key) {
                if (!$this->grid[$key]['marked']) {
                    // this row is not all matched
                    continue 2;
                }
            }
            // this is a winning row or column
            return true;
        }
        return false;
    }

    /**
     * Calculates the score of the card
     *
     * @return void
     */
    public function getScore()
    {
        if ($this->winningNumber == null) {
            return false;
        }
        // find the score of all unmarked numbers
        $sum = 0;
        foreach ($this->grid as $number) {
            if (!$number['marked']) {
                $sum += $number['value'];
            }
        }
        // multiply by the winning number on the card
        return $sum * $this->winningNumber;
    }
}

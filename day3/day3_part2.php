<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$submarine = new Submarine($values);

echo $submarine->calculateLifeSupport();

class Submarine
{

    private $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Calculates the current life support of the submarine
     *
     * @return void
     */
    public function calculateLifeSupport()
    {
        $oxygenValues = $this->values;
        $co2Values = $this->values;
        foreach (range(0, 11) as $key => $column) {
            $mostCommonBitOxygen = $this->countColumnBits($oxygenValues, $key);
            $mostCommonBitCo2 = $this->countColumnBits($co2Values, $key);
            if (count($oxygenValues) > 1) {
                $oxygenValues = $this->filterByBit($oxygenValues, $key, $mostCommonBitOxygen);
            }
            if (count($co2Values) > 1) {
                $co2Values = $this->filterByBit($co2Values, $key, $mostCommonBitCo2 == 1 ? 0 : 1);
            }
            if (count($oxygenValues) == 1 && count($co2Values) == 1) {
                break;
            }
        }
        return bindec($oxygenValues[array_key_first($oxygenValues)]) * bindec($co2Values[array_key_first($co2Values)]);
    }

    /**
     * Determines the most common bit in an array
     *
     * @param array $values The array of values to filter
     * @param int $column The column in which the Bit should be checked
     *
     * @return int
     */
    public function countColumnBits(array $values, int $column)
    {
        $positiveBitCount = 0;
        foreach ($values as $value) {
            $cols = str_split($value);
            $positiveBitCount += $cols[$column];
        }
        return $positiveBitCount >= count($values) / 2 ? 1 : 0;
    }

    /**
     * Filters the values given a column and a bit
     * Array keys for the values with the provided bit in the
     * provided column will be maintained
     *
     * @param array $values The array of values to filter
     * @param int $column The column in which the Bit should be checked
     * @param int $bit The Bit to match in the column (1 or 0)
     *
     * @return void
     */
    public function filterByBit(array $values, int $column, int $bit)
    {
        if (count($values) == 1) {
            return $values;
        }
        $filteredValues = [];
        foreach ($values as $value) {
            $cols = str_split($value);
            if ($cols[$column] == $bit) {
                $filteredValues[] = $value;
            }
        }
        return $filteredValues;
    }
}

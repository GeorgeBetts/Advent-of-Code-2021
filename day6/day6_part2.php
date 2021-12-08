<?php
$values = explode(',', file_get_contents('input.txt'));

$fishCount = [];
foreach (range(0, 8) as $value) {
    $fishCount[$value] = 0;
}
foreach ($values as $value) {
    $fishCount[intval($value)]++;
}

// loop 1 to 80 (days)
foreach (range(1, 256) as $day) {
    /**
     * Fish count holds a counter of the occurences of a fish with X days left to create a new lantern fish
     * e.g. 16 fish with 7 days left, 20 fish with 6 days left etc.
     * With the key being the number of days left and the value being the count
     */
    $newFishCount = $fishCount;
    // loop 0 to 8 - the max number of days a fish will go without creating a new fish
    foreach (range(0, 8) as $interval) {
        if ($interval == 0) {
            /**
             * A fish with 0 days left will create a new fish, so this is where they duplicate
             * The fish gets reset to 6, and the same number of new fish are created at 8
             */
            $newFishCount[8] = isset($fishCount[$interval]) ? $fishCount[$interval] : 0;
            $newFishCount[6] = isset($fishCount[$interval]) ? $fishCount[$interval] : 0;
        } else if ($interval == 7) {
            // Interval 6 is handled different because it's added in addition to the new fish
            $newFishCount[6] += isset($fishCount[$interval]) ? $fishCount[$interval] : 0;
        } else {
            // For all other intervals the days until a new fish is created is - 1
            $newFishCount[$interval - 1] = isset($fishCount[$interval]) ? $fishCount[$interval] : 0;
        }
    }
    $fishCount = $newFishCount;
}

echo array_sum($fishCount);

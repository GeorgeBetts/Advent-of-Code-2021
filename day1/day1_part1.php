<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

// counter for the number of times the sonar increases
$depthIncreaseCount = 0;

// loop each value to check if the sonar increases over the previous value
foreach ($values as $key => $value) {
    if ($key == 0) {
        continue;
    }
    // check the value is greater than the previous value
    if ($values[$key - 1] < $value) {
        $depthIncreaseCount++;
    }
}

echo $depthIncreaseCount;

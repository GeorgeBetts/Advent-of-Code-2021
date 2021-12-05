<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

/**
 * The plots array will have keys equal to the x and y coordinates of the plot
 * i.e the plot 24,200 will have the key '24-200'
 *
 * The value will be a count of how many times it's been plotted
 */
$plots = [];

foreach ($values as $value) {
    $coordinates = readCoordinates($value);
    $horizontal = false;
    $verticle = false;
    if ($coordinates['x'][0] == $coordinates['x'][1]) {
        $verticle = true;
    } else if ($coordinates['y'][0] == $coordinates['y'][1]) {
        $horizontal = true;
    }
    if ($horizontal) {
        // plot the X range
        $range = range(min($coordinates['x']), max($coordinates['x']));
        foreach ($range as $plot) {
            if (isset($plots[$plot . '-' . $coordinates['y'][0]])) {
                $plots[$plot . '-' . $coordinates['y'][0]]++;
            } else {
                $plots[$plot . '-' . $coordinates['y'][0]] = 1;
            }
        }
    } elseif ($verticle) {
        // plot the Y range
        $range = range(min($coordinates['y']), max($coordinates['y']));
        foreach ($range as $plot) {
            if (isset($plots[$coordinates['x'][0] . '-' . $plot])) {
                $plots[$coordinates['x'][0] . '-' . $plot]++;
            } else {
                $plots[$coordinates['x'][0] . '-' . $plot] = 1;
            }
        }
    } else {
        // the line is diagonal
        // create the x range
        $xRange = range(min($coordinates['x']), max($coordinates['x']));
        if ($coordinates['x'][0] > $coordinates['x'][1]) {
            $xRange = array_reverse($xRange);
        }
        // create the y range
        $yRange = range(min($coordinates['y']), max($coordinates['y']));
        if ($coordinates['y'][0] > $coordinates['y'][1]) {
            $yRange = array_reverse($yRange);
        }
        foreach (range(0, count($xRange) - 1) as $key) {
            if (isset($plots[$xRange[$key] . '-' . $yRange[$key]])) {
                $plots[$xRange[$key] . '-' . $yRange[$key]]++;
            } else {
                $plots[$xRange[$key] . '-' . $yRange[$key]] = 1;
            }
        }
    }
}

$overlapCount = 0;
foreach ($plots as $plot) {
    if ($plot > 1) {
        $overlapCount++;
    }
}

echo $overlapCount;

function readCoordinates($value)
{
    $split = explode(' -> ', $value);
    $start = explode(',', $split[0]);
    $end = explode(',', $split[1]);
    return [
        'x' => [$start[0], $end[0]],
        'y' => [$start[1], $end[1]]
    ];
}

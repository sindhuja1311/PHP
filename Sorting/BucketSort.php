<?php

/**
 * Sorts an array of numbers using the Bucket Sort algorithm without using the sort function.
 *
 * @param array $arr An array of numbers to be sorted.
 * @return array The sorted array.
 */
function bucketSort(&$arr) {
    $n = count($arr);

    // If the array has 0 or 1 element, it's already sorted
    if ($n <= 1) {
        return $arr;
    }

    // Check if all elements are the same
    if (count(array_count_values($arr)) === 1) {
        return $arr;
    }

    // Find the minimum and maximum values in the input array
    $minVal = min($arr);
    $maxVal = max($arr);

    // Calculate the range of values in the input array
    $range = $maxVal - $minVal;
    $bucketCount = $n; // Number of buckets

    // Create buckets
    $buckets = array_fill(0, $bucketCount, []);

    // Distribute elements into buckets
    foreach ($arr as $value) {
        $index = (int)(($value - $minVal) * ($bucketCount - 1) / $range);
        $buckets[$index][] = $value;
    }

    // Sort each bucket using an auxiliary array (counting sort within each bucket)
    $k = 0;
    for ($i = 0; $i < $bucketCount; $i++) {
        $bucketSize = count($buckets[$i]);
        if ($bucketSize > 0) {
            countingSort($buckets[$i]);
            for ($j = 0; $j < $bucketSize; $j++) {
                $arr[$k] = $buckets[$i][$j];
                $k++;
            }
        }
    }
}

// Counting sort implementation within a bucket
function countingSort(&$arr) {
    $minValue = min($arr);
    $maxValue = max($arr);
    $range = $maxValue - $minValue + 1;
    $count = array_fill(0, $range, 0);

    $n = count($arr);
    $output = array_fill(0, $n, 0);

    // Count the occurrences of each value in the bucket
    for ($i = 0; $i < $n; $i++) {
        $count[$arr[$i] - $minValue]++;
    }

    // Calculate the cumulative count
    for ($i = 1; $i < $range; $i++) {
        $count[$i] += $count[$i - 1];
    }

    // Rearrange the elements based on the count
    for ($i = $n - 1; $i >= 0; $i--) {
        $output[$count[$arr[$i] - $minValue] - 1] = $arr[$i];
        $count[$arr[$i] - $minValue]--;
    }

    // Copy the sorted elements back to the original array
    for ($i = 0; $i < $n; $i++) {
        $arr[$i] = $output[$i];
    }
}

// Example usage with duplicate numbers:
$inputArray = [11, 2, 3, 3, 3, 3, -1, 0, 99];

echo "Original Array: " . implode(", ", $inputArray) . "\n";

// Check if all elements are the same
if (count(array_count_values($inputArray)) === 1) {
    echo "All elements are the same, so the array remains unchanged.\n";
    echo implode(", ", $inputArray);
} else {
    bucketSort($inputArray);
    echo "Sorted Array: " . implode(", ", $inputArray) . "\n";
}
?>

<?php

/**
 * @param array $map
 * @return int
 */
function solution(array $map): int
{
    // Check map count
    if (empty($map) || !is_array($map[0])) {
        throw new InvalidArgumentException('Invalid labyrinth map structure.');
    }

    $h = count($map);
    $w = $h ? count($map[0]) : 0;

    if ($h < 2 || $w < 2) {
        throw new InvalidArgumentException('Map dimensions must be at least 2×2.');
    }

    if ($h > 20 || $w > 20) {
        throw new InvalidArgumentException('Map dimensions must not be bigger than 20×20.');
    }

    // Check that all rows have the same width and there are no invalid values
    foreach ($map as $r => $row) {
        if (count($row) !== $w) {
            throw new InvalidArgumentException('All rows in the map must be of equal length.');
        }
        foreach ($row as $c => $cell) {
            if (!($cell === 0 || $cell === 1)) {
                $row = $r + 1;
                $col = $c + 1;
                throw new InvalidArgumentException("Invalid map value at row " . $row . " column " . $col . ". Must be 0 or 1.");
            }
        }
    }

    if ($map[0][0] !== 0 || $map[$h - 1][$w - 1] !== 0) {
        throw new InvalidArgumentException('Start or end cell is not passable - must be 0.');
    }

    $queue = new SplQueue();
    //row = $h - 1 => bottom row
    //col = $w - 1 => rightmost column
    //usedWall = false => haven’t removed any wall yet
    //distance = 1 => count the starting cell as step 1
    $queue->enqueue([$h - 1, $w - 1, false, 1]);

    $visited = [];
    for ($row = 0; $row < $h; $row++) {
        $visited[$row] = [];
        for ($col = 0; $col < $w; $col++) {
            $visited[$row][$col] = [false, false];
        }
    }

    // Mark the starting point as visited with "usedWall = false"
    $visited[$h - 1][$w - 1][0] = true;

    // Directions
    $directions = [
        [-1, 0], // up
        [1, 0],  // down
        [0, -1], // left
        [0, 1],  // right
    ];

    while (!$queue->isEmpty()) {
        [$row, $col, $usedWall, $dist] = $queue->dequeue();

        // Check if we've reached the exit (top-left => 0,0)
        if ($row === 0 && $col === 0) {
            return $dist;
        }

        // Explore directions
        foreach ($directions as $direction) {
            $newRow = $row + $direction[0];
            $newCol = $col + $direction[1];

            if ($newRow < 0 || $newRow >= $h || $newCol < 0 || $newCol >= $w) {
                continue;
            }

            if ($map[$newRow][$newCol] === 0) {
                // Passable cell
                if (!$visited[$newRow][$newCol][$usedWall]) {
                    $visited[$newRow][$newCol][$usedWall] = true;
                    $queue->enqueue([$newRow, $newCol, $usedWall, $dist + 1]);
                }
            } else {
                // Wall
                if (!$usedWall) {
                    if (!$visited[$newRow][$newCol][1]) {
                        $visited[$newRow][$newCol][1] = true;
                        $queue->enqueue([$newRow, $newCol, true, $dist + 1]);
                    }
                }
            }
        }
    }

    // no path found - unexpected
    throw new RuntimeException('No path found (unexpected).');
}

//run with simple example
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    // Example labyrinth
    $exampleMap = [
        [0, 0, 0, 0, 0, 0],
        [1, 1, 1, 1, 1, 0],
        [0, 0, 0, 0, 0, 0],
        [0, 1, 1, 1, 1, 1],
        [0, 1, 1, 1, 1, 1],
        [0, 0, 0, 0, 0, 0]
    ];
    try {
        $result = solution($exampleMap);
        echo  $result;
    } catch (Throwable $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}



# Escape a Labyrinth (PHP 8)

This is a small CLI application that computes the length of the shortest path in a labyrinth from the bottom-right corner to the top-left corner, given that you may remove one wall if needed.

## How It Works

- The labyrinth is represented by a 2D matrix of 0s and 1s:
    - `0` means the cell is passable.
    - `1` means the cell is a wall.
- The starting position is the bottom-right cell of the matrix `(h-1, w-1)`.
- The target (exit) is the top-left cell `(0, 0)`.
- We are allowed to remove **one** wall (`1`) if it helps shorten the path.
- Moves are restricted to the four cardinal directions (no diagonal moves).
- The function returns the total number of cells in the shortest path, counting both the entrance and exit.

### Key Points

1. **Data Structures**:
    - A `SplQueue` for BFS.
    - A 3D visited array to handle the state of "used wall removal" vs. "not used wall removal".

2. **Input Validation**:
    - Checks that the map is not empty and rectangular.
    - Checks is the map dimensions are not smaller than 2x2 or bigger than 20x20.
    - Check for invalid values (different from 0 and 1) .

3. **Algorithm**:
    - A BFS that tracks whether we have used our “wall removal” option or not.
    - Each BFS state = `(row, col, usedWall, distance)`.
    - If `usedWall` is `false`, we still have the option to convert a wall to a passable cell once.

4. **Testing**:
    - 2 test cases provided in the task
    - 6 more passable cases 
    - 8 unpassable cases

5. **Limitations**:
    - The labyrinth size is restricted (2 to 20 in width and height as per the problem statement), so a BFS is efficient enough.

## Usage

1. Make sure you have PHP 8 installed.
2. Place the file `labyrinth.php` in a folder of your choice.
3. Open a terminal and navigate to that folder.

### Run the Example Map 

```bash
php labyrinth.php

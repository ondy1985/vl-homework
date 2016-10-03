<?php

/**
 * @author Ondrej Cernay
 *
 *
 */

class Paint {

    protected function floodFill($screen, $x, $y, $color, $originalColor) {
        // end flood fill if the current square is different color than original one
        // or we are out of bounds
        if (
            $screen[$y][$x] !== $originalColor ||
            $y >= count($screen) ||
            $x >= count($screen[0]) ||
            $y < 0 || $x < 0
        ) {
            return $screen;
        }

        $screen[$y][$x] = $color;

        // fill right
        $screen = $this->floodFill($screen, $x+1, $y, $color, $originalColor);
        // left
        $screen = $this->floodFill($screen, $x-1, $y, $color, $originalColor);
        // up
        $screen = $this->floodFill($screen, $x, $y-1, $color, $originalColor);
        // down
        $screen = $this->floodFill($screen, $x, $y+1, $color, $originalColor);

        return $screen;
    }

    public function fill($screen, $x, $y, $color) {
        if (!is_array($screen) || count($screen) === 0) {
            throw new Exception("Screen must a non-empty array");
        }

        if ($screen[$y][$x] === $color) {
            return $screen; // no need to fill, it's the same color
        }

        return $this->floodFill($screen, $x, $y, $color, $screen[$y][$x]);
    }
}

function print_array($array) {
    foreach ($array as $line) {
        echo join(" ", $line) . "\n";
    }
}

$screen = [
    [0, 4, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 1],
    [0, 4, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 1],
    [0, 4, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 1],
    [0, 4, 0, 0, 0, 2, 7, 7, 7, 7, 7, 7, 1],
    [0, 4, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 1],
    [0, 4, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 1],
    [0, 0, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 1],
    [0, 0, 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 1]
];

$paint = new Paint();
if ($argc < 4) {
    echo "Usage: `php paint.php <x> <y> <color>\n";
} else {
    print_array($paint->fill($screen, intval($argv[1]), intval($argv[2]), intval($argv[3])));
}
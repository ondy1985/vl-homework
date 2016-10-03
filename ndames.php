<?php
/**
 * Created by PhpStorm.
 * User: Ondy
 * Date: 29.9.2016
 * Time: 19:47
 *
 */

/*
    SOLVING FOR N=8     SOLUTIONS FOUND: 92     DURATION: 0 SECONDS
    SOLVING FOR N=9     SOLUTIONS FOUND: 352    DURATION: 0 SECONDS
    SOLVING FOR N=10    SOLUTIONS FOUND: 724    DURATION: 1 SECONDS
    SOLVING FOR N=11    SOLUTIONS FOUND: 2680   DURATION: 6 SECONDS
    SOLVING FOR N=12    SOLUTIONS FOUND: 14200  DURATION: 35 SECONDS
    SOLVING FOR N=13    SOLUTIONS FOUND: 73712  DURATION: 208 SECONDS
    SOLVING FOR N=14    SOLUTIONS FOUND: 365596 DURATION: 1209 SECONDS
 */

class NDamesProblemSolver {

    const EMPTY_SQUARE = '_';
    const DAME = '@';

    public function initChessboard($n) {
        $chessboard = [];
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $chessboard[$x][$y] = self::EMPTY_SQUARE;
            }
        }

        return $chessboard;
    }

    protected function placeDame($x, $y, $chessboard) {
        $chessboard[$x][$y] = self::DAME;

        return $chessboard;
    }

    public function tryToPlaceADame($x, $y, $chessboard, $damesPlaced = 0, $solutionsFound = 0) {

        $n = count($chessboard);
        if ($x >= $n || $y >= $n) return $solutionsFound; // we are out of board

        if (false === $this->isThreatOnSquare($x, $y, $chessboard)) {
            if ($n === $damesPlaced + 1) {
                // if all dames would placed, increase solution count
                // and try not placing it here to see if we can come with another solution
                return $this->tryToPlaceADame($x, $y + 1, $chessboard, $damesPlaced, $solutionsFound+1);
            }

            // this would not be a solution
            // try not placing the dame here and count how many solutions this would give us
            $solutionsFound += $this->tryToPlaceADame($x, $y + 1, $chessboard, $damesPlaced, 0);

            // place it here and continue on next column
            $newChessboard = $this->placeDame($x, $y, $chessboard);
            return $this->tryToPlaceADame($x + 1, 0, $newChessboard, $damesPlaced + 1, $solutionsFound);
        }

        // if dame can not be placed, try to place it into next row
        return $this->tryToPlaceADame($x, $y+1, $chessboard, $damesPlaced, $solutionsFound);
    }

    public function isThreatOnSquare($x, $y, $chessboard) {
        $n = count($chessboard);

        // check horizontal threat
        for ($i = 0; $i < $n; $i++) {
            if ($i === $x) continue; // no need to check threat on the tested square
            if ($chessboard[$i][$y] === self::DAME) {
                return true;

            }
        }

        // check vertical threat
        for ($i = 0; $i < $n; $i++) {
            if ($i === $y) continue; // no need to check threat on the tested square
            if ($chessboard[$x][$i] === self::DAME) {
                return true;
            }
        }

        // check diagonal threat from top-left
        for ($xx = $x - 1, $yy = $y - 1; $xx >= 0 && $yy >= 0; $xx--, $yy--) {
            if ($chessboard[$xx][$yy] === self::DAME) {
                return true;
            }
        }

        // check diagonal threat from bottom-right
        for ($xx = $x + 1, $yy = $y + 1; $xx < $n && $yy < $n; $xx++, $yy++) {
            if ($chessboard[$xx][$yy] === self::DAME) {
                return true;
            }
        }

        // check diagonal threat from bottom-left
        for ($xx = $x - 1, $yy = $y + 1; $xx >= 0 && $yy < $n; $xx--, $yy++) {
            if ($chessboard[$xx][$yy] === self::DAME) {
               return true;
            }
        }

        // check diagonal threat from top-right
        for ($xx = $x + 1, $yy = $y - 1; $xx < $n && $yy >= $n; $xx++, $yy--) {
            if ($chessboard[$xx][$yy] === self::DAME) {
                return true;
            }
        }

        return false;
    }

    public function solve($n) {
        echo "SOLVING FOR N={$n}\n";

        $start = time();
        $chessboard = $this->initChessboard($n);
        $solutions = $this->tryToPlaceADame(0, 0, $chessboard, 0);
        $duration = time() - $start;

        echo "\nSOLUTIONS FOUND: $solutions";
        echo "\nDURATION: $duration SECONDS";
        echo "\n*** EXIT ***";
    }
}

$solver = new NDamesProblemSolver();

if ($argc >= 2 && intval($argv[1]) > 0) {
    $solver->solve(intval($argv[1]));
} else {
    echo "USAGE: `php ndames.php <n>`\n";

}

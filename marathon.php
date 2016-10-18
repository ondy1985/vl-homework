<?php

class Marathon {


    function findLeaders($numbers, $currentProblem, $currentOrder = [], $iteration = 0) {
        $rest = [];
        $newProblem = $currentProblem;
        foreach ($numbers as $number) {
            $wasOutrunned = false;
            foreach ($currentProblem as $pair) {
                $follower = $pair[1];
                if ($number === $follower) {
                    $wasOutrunned = true;
                    $rest[] = $number;
                    break;
                }
            }

            if (false === $wasOutrunned) {
                $currentOrder[] = $number;
                foreach ($newProblem as $key => $pair) {
                    $leader = $pair[0];
                    if ($number === $leader) {
                        unset($newProblem[$key]);
                    }
                }
            }
        }

        if (count($rest) === 0) {
            return $currentOrder;
        }

        if (count($rest) === count($numbers)) {
            throw new Exception("STOP RUNNING IN CIRCLES!");
        }

        return $this->findLeaders($rest, $newProblem, $currentOrder, $iteration+1);
    }

    function solve($problem) {
        $maxNumber = 0;
        foreach ($problem as $pair) {
            $maxNumber = max($maxNumber, max($pair));
        }

        $allNumbers = [];
        for ($i = 1; $i <= $maxNumber; $i++) {
            $allNumbers[] = $i;
        }

        return $this->findLeaders($allNumbers, $problem);
    }
}

$problem = [
    [5, 3],
    [2, 7],
    [1, 8],
    [4, 2],
    [5, 2],
];

$marathon = new Marathon();
print_r($marathon->solve($problem));
echo "\n";
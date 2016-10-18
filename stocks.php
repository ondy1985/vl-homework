<?php

class StockAnalyser {

    function findMaxProfit($prices) {
        $numberOfPrices = count($prices);
        if (false === is_array($prices) || $numberOfPrices === 0) {
            throw new Exception('$prices must be non-empty array');
        }

        if ($numberOfPrices === 1) {
            return 0;
        }

        $maxProfit = 0;

        for ($buyPriceIndex = 0; $buyPriceIndex < $numberOfPrices; $buyPriceIndex++) {
            $buyPrice = $prices[$buyPriceIndex];


            for ($sellPriceIndex = $buyPriceIndex; $sellPriceIndex < $numberOfPrices; $sellPriceIndex++) {
                $currentProfit = $prices[$sellPriceIndex] - $buyPrice;

                if ($currentProfit > $maxProfit) {
                    $maxProfit = $currentProfit;
                }
            }
        }
        
        return $maxProfit;
    }

    function findMaxProfitLinear($prices) {
        $numberOfPrices = count($prices);
        if (false === is_array($prices) || $numberOfPrices === 0) {
            throw new Exception('$prices must be non-empty array');
        }

        if ($numberOfPrices === 1) {
            return 0;
        }

        $maxProfit = 0;
        $minPrice = $prices[0];

        for ($i = 1; $i < $numberOfPrices; $i++) {
            if ($prices[$i] < $minPrice) {
                $minPrice = $prices[$i];
            }

            $profit = $prices[$i] - $minPrice;
            if ($maxProfit < $profit) {
                $maxProfit = $profit;
            }
        }

        return $maxProfit;
    }


}


$prices = [17, 18, 20, 15, 19];

$stockAnalyser = new StockAnalyser();
//echo $stockAnalyser->findMaxProfit($prices) . "\n";
echo $stockAnalyser->findMaxProfitLinear($prices) . "\n";
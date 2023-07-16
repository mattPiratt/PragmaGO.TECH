<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use PragmaGoTech\Interview\Model\FeeDefinitionsInterface;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
class FeeDefinitions implements FeeDefinitionsInterface
{
    private $definitions = [];

    public function __construct(array $definitions)
    {
        $this->setDefinitions($definitions);
    }

    public function setDefinitions(array $definitions): void
    {
        $this->definitions = $definitions;
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * Find two neighbour ranges close to given $amoubnt, 
     * that can be later used to calculate exact fee
     */
    public function findNearFeeRanges(float $amount): NearFeeRangesStruct
    {
        //check the Amount if is in the range (automaticle in context of defined ranges)
        reset($this->definitions);
        $firstKey = key($this->definitions);
        end($this->definitions);
        $lastKey = key($this->definitions);
        if ($amount < $firstKey or $amount > $lastKey) {
            throw new \InvalidArgumentException("Amount is not in the range of 1000>20000 PLN");
        }

        $keys = array_keys($this->definitions);
        $iterator = 0;

        foreach ($this->definitions as $defAmount => $defFee) {

            if ($defAmount >= $amount) {
                //found the right record.

                // case when the amount is located in the edge of the FeeCalculatorDefTable
                if ($iterator == 0) {
                    $prevKey = $keys[$iterator];
                } else {
                    $prevKey = $keys[$iterator - 1];
                }
                $lowEndFee = $this->definitions[$prevKey];
                $lowEndAmount = $prevKey;

                // Lets find the next amount
                $highEndFee = $defFee;
                $highEndAmount = $defAmount;
                return new NearFeeRangesStruct($lowEndFee, $highEndFee, $lowEndAmount, $highEndAmount);
            }
            //track the shift in the FeeCalculatorDefTable
            $iterator++;
        }
        throw new \Exception("This should not happen. Amount:" . $amount);
    }
}

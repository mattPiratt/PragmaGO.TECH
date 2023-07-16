<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\NearFeeRangesStruct;
use PragmaGoTech\Interview\Model\FeeDefinitionsStorage;


class FeeCalculator implements FeeCalculatorInterface
{
    private FeeDefinitionsStorage $feeDefinitions;

    public function __construct(FeeDefinitionsStorage $feeDefinitions)
    {
        $this->feeDefinitions = $feeDefinitions;
    }

    public function calculate(LoanProposal $application): float
    {
        $amount = $application->amount();
        $term = $application->term();

        $nearFeeRanges = $this->feeDefinitions
            ->getFeeDefinitions($term)
            ->findNearFeeRanges($amount);

        $resultFee = $this->calculateFee($nearFeeRanges, $amount);

        return $resultFee;
    }

    /**
     * Calculate fee with the requirement that the should be rounded up 
     * such that fee + loan amount is an exact multiple of 5.
     */
    private function calculateFee(NearFeeRangesStruct $nearFeeRanges, float $amount): float
    {
        // Calculate vertor
        $a = ($nearFeeRanges->highEndFee - $nearFeeRanges->lowEndFee) / ($nearFeeRanges->highEndAmount - $nearFeeRanges->lowEndAmount);

        // calculate shift
        $b = $nearFeeRanges->lowEndFee - ($a * $nearFeeRanges->lowEndAmount);

        // calculate value for $resultFee - IMPORTANT! - we are round ing fee to a round Number
        $resultFee = round($a * $amount + $b, 2);

        return self::roundUpToMultipleOf5($resultFee, $amount);
    }

    /**
     * fee + loan amount is an exact multiple of 5
     */
    private static function roundUpToMultipleOf5(float $fee, float $loan): float
    {
        $total = $fee + $loan;
        //round up this total to nearest multiply of 5
        $roundedUpTotal = ceil($total / 5) *  5;
        $missingPiece = $total - $roundedUpTotal;

        return round($fee - $missingPiece, 2);
    }
}

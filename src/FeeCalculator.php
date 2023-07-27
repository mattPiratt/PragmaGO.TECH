<?php

declare(strict_types=1);

namespace MattPiratt\Interview;

use MattPiratt\Interview\Model\LoanProposal;
use MattPiratt\Interview\Model\NearFeeRangesStruct;
use MattPiratt\Interview\Model\FeeDefinitionsStorage;


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
            ->get($term)
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
        // Calculate factor
        $factor = ($nearFeeRanges->highEndFee - $nearFeeRanges->lowEndFee) / ($nearFeeRanges->highEndAmount - $nearFeeRanges->lowEndAmount);

        // calculate shift
        $shift = $nearFeeRanges->lowEndFee - ($factor * $nearFeeRanges->lowEndAmount);

        // calculate value for $resultFee
        $resultFee = round($factor * $amount + $shift, 2);

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

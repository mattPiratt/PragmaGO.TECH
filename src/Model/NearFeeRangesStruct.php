<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

/**
 * This class is a Data structure, to create a contract
 * of data format between two functions
 */
class NearFeeRangesStruct
{
    public function __construct(
        public float $lowEndFee,
        public float $highEndFee,
        public float $lowEndAmount,
        public float $highEndAmount
    ) {
    }
}

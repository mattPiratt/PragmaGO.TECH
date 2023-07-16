<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

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

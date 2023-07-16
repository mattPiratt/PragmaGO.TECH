<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

interface FeeDefinitionsStorageInterface
{
    /**
     * @return FeeDefinitionsForLoan The definitions for loan
     */
    public function getFeeDefinitions(int $term): FeeDefinitions;

    /**
     * @return void Setter for the definitions for loan
     */
    public function setFeeDefinitions(int $term, FeeDefinitions $feeDefinitions): void;
}

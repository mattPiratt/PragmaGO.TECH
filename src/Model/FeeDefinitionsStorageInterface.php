<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

interface FeeDefinitionsStorageInterface
{
    /**
     * Gets the definitions for loan in given $term
     */
    public function getFeeDefinitions(int $term): FeeDefinitions;

    /**
     * Sets definitions for loan (in given term) in the storage
     */
    public function setFeeDefinitions(int $term, FeeDefinitions $feeDefinitions): void;
}

<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

class FeeDefinitionsStorage implements FeeDefinitionsStorageInterface
{
    //there are only two possible types of loan
    const TERM12 = 12;
    const TERM24 = 24;

    private $feeDefinitions = [];

    public function getFeeDefinitions(int $term): FeeDefinitions
    {
        return $this->feeDefinitions[$term];
    }

    public function setFeeDefinitions(int $term, FeeDefinitions $feeDefinitions): void
    {
        if ($term != self::TERM12 and $term != self::TERM24) {
            throw new \InvalidArgumentException("Term parameter must be one of: 12 or 24 months.");
        }
        $this->feeDefinitions[$term] = $feeDefinitions;
    }
}

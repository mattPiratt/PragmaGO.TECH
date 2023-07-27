<?php

declare(strict_types=1);

namespace MattPiratt\Interview\Model;

interface FeeDefinitionsStorageInterface
{
    /**
     * Gets the definitions for loan in given $term
     */
    public function get(int $term): FeeDefinitions;

    /**
     * Sets definitions for loan (in given term) in the storage
     */
    public function set(int $term, FeeDefinitions $feeDefinitions): void;
}

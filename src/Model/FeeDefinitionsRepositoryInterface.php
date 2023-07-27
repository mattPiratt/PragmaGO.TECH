<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

interface FeeDefinitionsRepositoryInterface
{
    /**
     * Returns array representing Fee definitions
     */
    public function getData(string $path): array;
}

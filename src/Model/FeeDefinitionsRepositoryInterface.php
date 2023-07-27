<?php

declare(strict_types=1);

namespace MattPiratt\Interview\Model;

interface FeeDefinitionsRepositoryInterface
{
    /**
     * Returns array representing Fee definitions
     */
    public function getData(string $path): array;
}

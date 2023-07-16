<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

interface FeeDefinitionsInterface
{
    /**
     * @return array The definitions for loan ranges and it's fees
     */
    public function getDefinitions(): array;
}

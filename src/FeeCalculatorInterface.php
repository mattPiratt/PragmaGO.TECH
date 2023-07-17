<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeCalculatorInterface
{
    /**
     * Calculates fee for given Loan proposal
     */
    public function calculate(LoanProposal $application): float;
}

<?php

declare(strict_types=1);

namespace MattPiratt\Interview;

use MattPiratt\Interview\Model\LoanProposal;

interface FeeCalculatorInterface
{
    /**
     * Calculates fee for given Loan proposal
     */
    public function calculate(LoanProposal $application): float;
}

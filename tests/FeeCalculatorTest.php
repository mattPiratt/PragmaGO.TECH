<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator;

define('ROOT_PATH', __DIR__ . '/../');
require_once ROOT_PATH . 'sunrise.php';

final class FeeCalculatorTest extends TestCase
{
    private $feeDefinitionsStorage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->feeDefinitionsStorage = initFeeDefinitionsStorage();
    }

    public function calculateCorrectnessDataProvider()
    {
        return [
            [24, 2750, 115],
            [12, 2578.98543, 91.01],
            [12, 4500, 110],
            [24, 20000, 800]
        ];
    }

    /**
     * @dataProvider calculateCorrectnessDataProvider
     */
    public function testCalculateCorrectness($term, $amount, $expectedFee): void
    {
        $application = new LoanProposal($term, $amount);
        $calculator = new FeeCalculator($this->feeDefinitionsStorage);
        $fee = $calculator->calculate($application);

        $this->assertEquals($expectedFee, $fee);
    }

    /**
     * @dataProvider calculateCorrectnessDataProvider
     * Requirement:
     * - The fee should be rounded up such that fee + loan amount is an exact multiple of 5.
     */
    public function testTheSumIsAlwaysMultipleOf5($term, $amount, $expectedFee): void
    {
        $application = new LoanProposal($term, $amount);
        $calculator = new FeeCalculator($this->feeDefinitionsStorage);
        $fee = $calculator->calculate($application);

        $actualSum = $fee + round($amount, 2);
        $remainder = $actualSum % 5;
        $this->assertEquals($remainder, 0);
    }


    public function loanOutOfRangeDataProvider()
    {
        return [
            [24, 100, 0],
            [24, 21000, 0]
        ];
    }

    /**
     * @dataProvider loanOutOfRangeDataProvider
     * Requirement:
     * - The minimum amount for a loan is 1,000 PLN, and the maximum is 20,000 PLN.
     */
    public function testLoanOutOfRange($term, $amount, $expectedFee): void
    {
        $this->expectException(InvalidArgumentException::class);

        $application = new LoanProposal($term, $amount);
        $calculator = new FeeCalculator($this->feeDefinitionsStorage);
        $fee = $calculator->calculate($application);
    }


    public function sumIsAlwaysARoundNumberDataProvider()
    {
        return [
            [12, 2578.98543, 2670],
            [24, 6644.83, 6915.0]
        ];
    }

    /**
     * @dataProvider sumIsAlwaysARoundNumberDataProvider
     * Requirement:
     * - fee + loan amount is always a round number
     */
    public function testSumIsAlwaysARoundNumber($term, $amount, $expectedSum): void
    {
        $application = new LoanProposal($term, $amount);
        $calculator = new FeeCalculator($this->feeDefinitionsStorage);
        $fee = $calculator->calculate($application);

        $this->assertEquals($expectedSum, $fee + round($amount, 2));
    }
}

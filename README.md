# PragmaGO.TECH Interview Test - Fee Calculation

## The test

The requirement was to build a fee calculator that - given a monetary **amount** and a **term** (the contractual duration of the loan, expressed as a number of months) - will produce an appropriate fee for a loan, based on a fee structure and a set of rules described below. A general contract for this functionality is defined in the interface `FeeCalculator`.

Implement your solution such that it fulfills the requirements.

- The fee structure does not follow a formula.
- Values in between the breakpoints should be interpolated linearly between the lower bound and upper bound that they fall between.
- The number of breakpoints, their values, or storage might change.
- The term can be either 12 or 24 (number of months), you can also assume values will always be within this set.
- The fee should be rounded up such that fee + loan amount is an exact multiple of 5.
- The minimum amount for a loan is 1,000 PLN, and the maximum is 20,000 PLN.
- You can assume values will always be within this range but they may be any value up to 2 decimal places.

Example inputs/outputs:
|Loan amount |Term |Fee |
|-------------|-----------|--------|
|11,500 PLN |24 months |460 PLN |
|19,250 PLN |12 months |385 PLN |

# Fee Structure and definitions

The fee structure doesn't follow a particular algorithm and it is possible that the same fee will be applicable for different amounts.
Example definitions of loan values and corresponding fees can be seen in fixtures/termXX.csv files. Any number of definitions can be defined there.

# Installation and how to run

A database or any other external dependency is not required for this test.

```bash
composer install
php solution.php --term 24 --amount 2750
./vendor/bin/phpunit tests/
```

# Developer notes

- this code requires PHP 8.2
- Fee definitions for given ranges are in "fixtures" dir, CSV files. It can be modified to any number of ranges with any fee values
- I have provided multiple unit tests, that confirm if the calculations are ok in a few different ways
- by checking the fee value
- by checking the sum of loan+fee
- by checking if loan+fee are multiple of 5
- by checking the "out of range" scenario
- this requirement "The fee should be rounded up such that fee + loan amount is an exact multiple of 5" was unclear to me. Hope I got it right and the implementation represents it
- there is no Struct in PHP, but to create a contract between findNearFeeRanges() function, that returns some data structure, and calculateFee() that requires it, I have created NearFeeRangesStruct that simulates something similar to Struct (see this RFC: https://wiki.php.net/rfc/structs)
- to be a little fancy, I have used PHP8.2 new feature of Constructor Property Promotion ( RFC: https://wiki.php.net/rfc/constructor_promotion ). It is in src/Model/NearFeeRangesStruct.php:
- I've made modifications, so that ranges of 1,000~20,000 are not fixed, but red from the ranges definitions (CSV files)
- In general, I have tried to write multiple objects and interfaces to show some of OOP, but I did not want to go too far (by forcing patterns like Factory, Adapter, Singleton, etc., or by using abstract classes). My goal was to deliver dome of the DRY, KISS and SOLID principles, but without overdoing it.
- I ran this code on MacOS with PHP installed from brew, and composer installed locally. If you run into trouble starting this code, please let me know

# Interview Test - Fee Calculation

## The test

The requirement was to build a fee calculator that - given a monetary **amount** and a **term** (the contractual duration of the loan, expressed as a number of months) - will produce an appropriate fee for a loan, based on a fee structure and a set of rules described below. A general contract for this functionality is defined in the interface `FeeCalculator`.

Implement solution such that it fulfills the requirements.

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
Example definitions of loan values and corresponding fees can be seen in fixtures/ directory. Definitions can be changed.

# Installation and how to run

A database or any other external dependency is not required for this test.

```bash
composer install
# run the code with 2 input parameters
php solution.php --term 24 --amount 2750
# run tests
./vendor/bin/phpunit tests/
```

# Developer notes

- this code requires PHP 8.2 and Composer version 2.5
- Fee definitions for given ranges are in "fixtures" dir. It can be modified to any number of ranges with any fee values
- I have provided multiple unit tests, that confirm if the calculations are ok in a few different ways
  - by checking the fee value
  - by checking the sum of loan+fee
  - by checking if loan+fee are multiple of 5
  - by checking the "out of range" scenario
- there is no Struct in PHP, but to create a contract between `findNearFeeRanges()` function, that returns some data structure, and `calculateFee()` that requires it, I have created `NearFeeRangesStruct` that simulates something similar to Struct (see this RFC: https://wiki.php.net/rfc/structs)
- to be a little fancy, I have used PHP8.2 new feature of Constructor Property Promotion ( RFC: https://wiki.php.net/rfc/constructor_promotion ). It is in src/Model/NearFeeRangesStruct.php:
- ranges of 1,000~20,000 are not fixed, but automaticaly set from the ranges definitions
- this code features Clean Code by:
  - Meaningful and Descriptive Variable Names
  - Proper Indentation and Formatting (https://prettier.io/ for VSCode )
  - DRY ( sunrise.php used for starting solution.php and for tests)
  - Keep Functions and Methods Short
  - Use Comments Sparingly and Purposefully
  - Consistent Coding Style
  - Follow PSR Standards ( PSR-1 & PSR-2 & PSR-4 autoloading )
  - Unit Testing
  - Avoid Global Variables
- this code features SOLID principles
  - Single Responsibility Principle - separate class for loading data from file, seperate that delivers Fee definitions to calculator
  - Open/Closed Principle - eg: `FeeDefinitionsInterface`
  - Liskov Substitution Principle - `CsvFeeDefinitionsRepository` and `JsonFeeDefinitionsRepository`
  - Interface Segregation Principl: `FeeDefinitionsInterface`, `FeeDefinitionsStorageInterface`
  - Dependency Inversion Principle: Repository pattern for `FeeDefinitionsRepositoryInterface`, and specific class of `CsvFeeDefinitionsRepository` and `JsonFeeDefinitionsRepository`
- I ran this code on MacOS with PHP installed from brew, and composer installed locally. If you run into trouble starting this code, please let me know

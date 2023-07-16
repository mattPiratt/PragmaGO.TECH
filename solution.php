<?php

declare(strict_types=1);
define('ROOT_PATH', __DIR__ . '/');
require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'sunrise.php';

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator;


// read script run options
$longopts  = array(
    "term:",    // Required value
    "amount:",  // Required value
);
$options = getopt('', $longopts);

//and validate if the options are correct
$amount = (float)round((float)$options['amount'], 2);
if ($amount < 1000 or $amount > 20000) die("Incorrect input. Aborting" . PHP_EOL);
$term = intval($options['term']);
$term = ($term == 12 or $term == 24) ? $term : die("Incorrect input. Aborting" . PHP_EOL);

$feeDefinitionsStorage = initFeeDefinitionsStorage();
$application = new LoanProposal($term, $amount);

$calculator = new FeeCalculator($feeDefinitionsStorage);
$fee = $calculator->calculate($application);
echo "Calculated fee: " . $fee . PHP_EOL;
echo "Calculated fee+amount: " . $fee + $amount . PHP_EOL;

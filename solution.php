<?php

declare(strict_types=1);
define('ROOT_PATH', __DIR__ . '/');
require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'sunrise.php';

use MattPiratt\Interview\Model\LoanProposal;
use MattPiratt\Interview\FeeCalculator;


// read script run options
$longopts  = array(
    "term:",    // Required value
    "amount:",  // Required value
);
$options = getopt('', $longopts);

$amount = (float)round((float)$options['amount'], 2);
$term = intval($options['term']);
//and validate if the term is correct
if (!($term == 12 or $term == 24)) die("Incorrect input. Aborting" . PHP_EOL);

$feeDefinitionsStorage = initFeeDefinitionsStorage();
$application = new LoanProposal($term, $amount);

$calculator = new FeeCalculator($feeDefinitionsStorage);
$fee = $calculator->calculate($application);
echo "Calculated fee: " . $fee . PHP_EOL;
echo "Calculated fee+amount: " . $fee + $amount . PHP_EOL;

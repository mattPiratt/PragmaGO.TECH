<?php

declare(strict_types=1);

use MattPiratt\Interview\Model\FeeDefinitions;
use MattPiratt\Interview\Model\FeeDefinitionsStorage;
use MattPiratt\Interview\Model\CsvFeeDefinitionsRepository;
use MattPiratt\Interview\Model\JsonFeeDefinitionsRepository;

function initFeeDefinitionsStorage(): FeeDefinitionsStorage
{
    //initialize loan-fee defs
    $csvStorage = new CsvFeeDefinitionsRepository();
    $dataTerm12 = $csvStorage->getData('fixtures/term12.csv');
    $jsonStorage = new JsonFeeDefinitionsRepository();
    $dataTerm24 = $jsonStorage->getData('fixtures/term24.json');

    $term12Defs = new FeeDefinitions($dataTerm12);
    $term24Defs = new FeeDefinitions($dataTerm24);

    $feeDefinitionsStorage = new FeeDefinitionsStorage();
    $feeDefinitionsStorage->set(FeeDefinitionsStorage::TERM12, $term12Defs);
    $feeDefinitionsStorage->set(FeeDefinitionsStorage::TERM24, $term24Defs);

    return $feeDefinitionsStorage;
}

<?php

declare(strict_types=1);

use PragmaGoTech\Interview\Model\FeeDefinitions;
use PragmaGoTech\Interview\Model\FeeDefinitionsStorage;


function initFeeDefinitionsStorage(): FeeDefinitionsStorage
{
    //initialize loan-fee defs
    $csvDataTerm12 = loadFixtureData('fixtures/term12.csv');
    $csvDataTerm24 = loadFixtureData('fixtures/term24.csv');

    $term12Defs = new FeeDefinitions($csvDataTerm12);
    $term24Defs = new FeeDefinitions($csvDataTerm24);


    $feeDefinitionsStorage = new FeeDefinitionsStorage();
    $feeDefinitionsStorage->setFeeDefinitions(FeeDefinitionsStorage::TERM12, $term12Defs);
    $feeDefinitionsStorage->setFeeDefinitions(FeeDefinitionsStorage::TERM24, $term24Defs);

    return $feeDefinitionsStorage;
}


function loadFixtureData(string $path): array
{
    if (($handle = fopen(ROOT_PATH . $path, 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $key = (int) $row[0];
            $value = (int) $row[1];
            $data[$key] = $value;
        }
        fclose($handle);
        return $data;
    }
    die('File at location ' . ROOT_PATH . $path . ' cannot be found.');
}

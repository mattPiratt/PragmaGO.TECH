<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

class CsvFeeDefinitionsRepository implements FeeDefinitionsRepositoryInterface
{
    public function getData(?string $path): array
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
}

<?php

declare(strict_types=1);

namespace MattPiratt\Interview\Model;

class JsonFeeDefinitionsRepository implements FeeDefinitionsRepositoryInterface
{
    public function getData(?string $path): array
    {
        if (file_exists(ROOT_PATH . $path)) {
            $result = [];
            $json = json_decode(file_get_contents(ROOT_PATH . $path), true);

            foreach ($json as $item) {
                $result[$item['amount']] = $item['fee'];
            }
            return $result;
        }
        die('File at location ' . ROOT_PATH . $path . ' cannot be found.');
    }
}

<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait KeyTransformer
{
    private function toCamelCase(array $data): array
    {
        return $this->transformKeys($data, true);
    }

    private function toSnakeCase(array $data): array
    {
        return $this->transformKeys($data);
    }

    private function transformKeys(array $data, bool $isCamel = false): array
    {
        $transformed = [];

        foreach ($data as $key => $value) {
            $transKey = $isCamel ? Str::camel($key) : Str::snake($key);

            if (is_array($value)) {
                $transformed[$transKey] = $this->transformKeys($value, $isCamel);
                continue;
            }

            $transformed[$transKey] = $value;
        }

        return $transformed;
    }
}

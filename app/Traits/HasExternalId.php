<?php



namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasExternalId
{
    private static function generateExternalId(Model|string $model, string $field = 'external_id'): string
    {
        $model = $model instanceof Model ? $model : new $model;

        do {
            $externalId = strtolower((string) Str::uuid());
        } while ($model::where($field, $externalId)->exists());

        return $externalId;
    }
}

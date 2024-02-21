<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Auditable
{
    use HasExternalId;

    public static function bootAuditable()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->external_id = static::generateExternalId($model);
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}

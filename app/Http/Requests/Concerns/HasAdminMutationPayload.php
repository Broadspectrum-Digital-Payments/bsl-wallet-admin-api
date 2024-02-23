<?php

declare(strict_types=1);

namespace App\Http\Requests\Concerns;

use App\Payloads\Admin\AdminMutationPayload;

trait HasAdminMutationPayload
{
    public function payload(): AdminMutationPayload
    {
        $validated = parent::validated();

        return new AdminMutationPayload(
            name: $validated['name'],
            email: $validated['email'],
            status: $validated['status'] ?? null,
            userType: $validated['userType'] ?? null
        );
    }
}

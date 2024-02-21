<?php

declare(strict_types=1);

namespace App\Payloads\Admin;

use App\Enums\AdminStatus;

final readonly class UpdateAdminPayload
{
    public function __construct(
        public int|string $id,
        public string $name,
        public string $email,
        public null|string|AdminStatus $status,
    ) {
    }

    public function toArray(): array
    {
        $data = get_object_vars($this);


        if (is_string($this->status)) $data['status'] = AdminStatus::tryFrom($this->status);
        if (is_null($data['status'])) unset($data['status']);

        unset($data['id']);

        return $data;
    }
}

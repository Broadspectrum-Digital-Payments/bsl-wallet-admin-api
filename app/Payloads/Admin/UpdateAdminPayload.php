<?php

declare(strict_types=1);

namespace App\Payloads\Admin;

use App\Enums\UserType;
use App\Enums\AdminStatus;
use App\Traits\KeyTransformer;

final readonly class UpdateAdminPayload
{
    use KeyTransformer;

    public function __construct(
        public string $name,
        public string $email,
        public null|string|AdminStatus $status,
        public null|string|UserType $userType,
    ) {
    }

    public function toArray(): array
    {
        $data = get_object_vars($this);

        if (is_string($this->status)) $data['status'] = AdminStatus::tryFrom($this->status);
        if (is_null($data['status'])) unset($data['status']);
        if (is_string($this->userType)) $data['userType'] = UserType::tryFrom($this->userType);
        if (is_null($data['userType'])) unset($data['userType']);

        return $this->toSnakeCase($data);
    }
}

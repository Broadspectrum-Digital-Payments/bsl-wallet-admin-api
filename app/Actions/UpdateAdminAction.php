<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Response\MessageResponse;
use App\Payloads\Admin\UpdateAdminPayload;
use App\Http\Resources\Admin\AdminUserResource;

final class UpdateAdminAction
{
    public function handle(User $user, UpdateAdminPayload $payload)
    {
        $isOk = $user->update($payload->toArray());
        $user = $user->refresh();

        return new MessageResponse(
            AdminUserResource::loginData($user),
            status: 200,
            success: $isOk ?? false,
            message: 'Admin Updated Successfully'
        );
    }
}

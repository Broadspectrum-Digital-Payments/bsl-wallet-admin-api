<?php



namespace App\Actions;

use App\Models\User;
use App\Response\MessageResponse;
use App\Payloads\Admin\AdminMutationPayload;
use App\Http\Resources\Admin\AdminUserResource;

final class UpdateAdminAction
{
    public function handle(User $user, AdminMutationPayload $payload)
    {
        $isOk = $user->update($payload->toArray());

        return new MessageResponse(
            AdminUserResource::loginData($user->refresh()),
            status: 200,
            success: $isOk ?? false,
            message: 'Admin Updated Successfully'
        );
    }
}

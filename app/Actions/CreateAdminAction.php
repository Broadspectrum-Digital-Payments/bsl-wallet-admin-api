<?php



namespace App\Actions;

use App\Response\MessageResponse;
use App\Services\Auth\AuthService;
use App\Services\Auth\PasswordResetService;
use App\Payloads\Admin\AdminMutationPayload;

final class CreateAdminAction
{
    public function __construct(
        private AuthService $authService,
        private PasswordResetService $resetService
    ) {
    }

    public function handle(AdminMutationPayload $payload)
    {
        $user = $this->authService->createUser(
            $payload->toArray() + ['password' => ($token = bin2hex(random_bytes(24)))]
        );

        $this->resetService->createPasswordData($user->email, $token);

        $this->authService->sendNewAdminPasswordResetLink($user, $token);

        return MessageResponse::success(
            status: 201,
            success: true,
            message: 'Admin Created Successfully'
        );
    }
}

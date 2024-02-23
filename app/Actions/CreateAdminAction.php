<?php

declare(strict_types=1);

namespace App\Actions;

use App\Response\MessageResponse;
use App\Services\Auth\AuthService;
use App\Services\Auth\PasswordResetService;
use App\Http\Requests\Admin\CreateAdminRequest;

final class CreateAdminAction
{
    public function __construct(
        private AuthService $authService,
        private PasswordResetService $resetService
    ) {
    }

    public function handle(CreateAdminRequest $request)
    {
        $user = $this->authService->createUser(
            $request->validated() + ['password' => ($token = bin2hex(random_bytes(24)))]
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

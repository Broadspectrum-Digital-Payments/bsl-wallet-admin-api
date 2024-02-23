<?php

namespace App\Http\Controllers\Auth;

use App\Response\MessageResponse;
use App\Services\Auth\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Admin\AdminUserResource;

final class LoginController
{
    public function __construct(private AuthService $auhService)
    {
    }

    public function __invoke(LoginRequest $request)
    {
        $user = $request->authenticate();

        $token = $this->auhService->createAccessToken($user);

        return new MessageResponse(
            data: $token + AdminUserResource::loginData($user),
            success: true,
            message: 'Login successful',
        );
    }
}

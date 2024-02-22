<?php

declare(strict_types=1);

namespace App\Actions;

use App\Response\MessageResponse;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Resources\Admin\AdminUserResource;

final class CreateAdminAction
{
    public function __construct(private AuthService $authService)
    {
    }

    public function handle(CreateAdminRequest $request)
    {
        $user = $this->authService->createUser(
            $request->validated() + ['password' => Hash::make($request->password)]
        );

        return new MessageResponse(
            AdminUserResource::loginData($user),
            status: 201,
            success: true,
            message: 'Admin Created Successfully'
        );
    }
}

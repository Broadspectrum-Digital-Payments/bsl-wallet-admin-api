<?php



namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Response\MessageResponse;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Services\Auth\PasswordResetService;
use App\Http\Resources\Admin\AdminUserResource;

class NewAdminPasswordResetController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private PasswordResetService $resetService
    ) {
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $tokenData = $this->resetService->getPasswordTokenData($request->token);

        if (is_null($tokenData)) {
            return MessageResponse::error(403, message: "invalid token");
        }

        $user = $this->authService->getUserByEmail($tokenData->email);

        $user->forceFill(['password' => Hash::make($request->password)])->save();

        $bearerToken = $this->authService->createAccessToken($user);

        $this->resetService->invalidatePasswordData($request->token);

        return MessageResponse::success(
            $bearerToken + AdminUserResource::loginData($user->refresh()),
            status: 200,
            message: 'Passowrd updated successfully'
        );
    }
}

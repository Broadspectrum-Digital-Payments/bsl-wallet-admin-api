<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\SendNewAdminPasswordResetLink;

final readonly class AuthService
{
    public function __construct(private DatabaseManager $manager)
    {
    }

    public function createUser(array $data): User|Model
    {
        return $this->manager->transaction(
            callback: fn () => User::query()->create($data),
            attempts: 2
        );
    }

    public function getUserByEmail(string $email): Model|Builder
    {
        return User::query()->where('email', $email)->firstOrFail();
    }

    public function createAccessToken(User $user, string $name = 'admin_login'): array
    {
        return ['bearerToken' => $user->createToken($name)->plainTextToken];
    }

    public function sendNewAdminPasswordResetLink(User $user, string $token)
    {
        Mail::to($user->email)->queue(new SendNewAdminPasswordResetLink($user, $token));
    }
}

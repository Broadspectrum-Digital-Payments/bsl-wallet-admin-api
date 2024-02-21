<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;

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

    public function createAccessToken(User $user, string $name = 'admin_login'): string
    {
        return $user->createToken($name)->plainTextToken;
    }
}

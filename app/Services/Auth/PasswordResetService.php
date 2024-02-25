<?php



namespace App\Services\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

final class PasswordResetService
{
    public function createPasswordData(string $email, string $token): bool
    {
        return $this->passwordResetTable()->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function getPasswordTokenData($token): ?object
    {
        return $this->passwordResetTable()->where('token', $token)->first();
    }

    public function invalidatePasswordData($token): int
    {
        return $this->passwordResetTable()->where('token', $token)->delete();
    }

    private function passwordResetTable(): Builder
    {
        return DB::table('password_reset_tokens');
    }
}

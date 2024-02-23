<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\UserType;
use App\Enums\AdminStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use App\Payloads\Admin\UpdateAdminPayload;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', $this->unique()],
            'status' => ['nullable', 'string', Rule::enum(AdminStatus::class)],
            'userType' => ['nullable', 'string', Rule::enum(UserType::class)],
        ];
    }

    private function unique(): Unique
    {
        return Rule::unique('users')->ignore($this->route('externalId')->id);
    }

    public function payload(): UpdateAdminPayload
    {
        $validated = parent::validated();

        return new UpdateAdminPayload(
            name: $validated['name'],
            email: $validated['email'],
            status: $validated['status'] ?? null,
            userType: $validated['userType'] ?? null
        );
    }
}

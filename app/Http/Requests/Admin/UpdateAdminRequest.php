<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\AdminStatus;
use Illuminate\Validation\Rule;
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
            'external_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'status' => ['nullable', 'string', Rule::enum(AdminStatus::class)],
        ];
    }

    public function payload(): UpdateAdminPayload
    {
        $validated = parent::validated();

        return new UpdateAdminPayload(
            id: $validated['external_id'],
            name: $validated['name'],
            email: $validated['email'],
            status: $validated['status'] ?? null
        );
    }
}

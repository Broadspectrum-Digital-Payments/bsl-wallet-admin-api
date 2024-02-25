<?php



namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Enums\UserType;
use App\Enums\AdminStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\HasAdminMutationPayload;

class CreateAdminRequest extends FormRequest
{
    use HasAdminMutationPayload;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'status' => ['nullable', 'string', Rule::enum(AdminStatus::class)],
            'userType' => ['nullable', 'string', Rule::enum(UserType::class)],
        ];
    }
}

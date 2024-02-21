<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public static function loginData($resource): array
    {
        return (new static($resource))->toLoginData();
    }

    public function toLoginData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at
        ];
    }
}

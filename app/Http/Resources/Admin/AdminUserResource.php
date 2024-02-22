<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
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
            'enternalId' => $this->external_id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'userType' => $this->user_type,
            'createdBy' => $this->created_by,
            'createdAt' => $this->created_at
        ];
    }
}

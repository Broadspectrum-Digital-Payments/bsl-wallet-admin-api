<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Traits\KeyTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    use KeyTransformer;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        unset($data['id']);

        return $this->toCamelCase($data);
    }
}

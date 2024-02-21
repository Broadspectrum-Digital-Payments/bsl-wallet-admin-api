<?php

declare(strict_types=1);

namespace App\Response;

use App\Enums\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final class MessageResponse implements Responsable
{
    /**
     * @param array{message:string} $data
     * @param Status $status
     */
    public function __construct(
        private readonly array $data,
        private readonly int $status = 200,
        private readonly bool $success = false,
        private readonly string $message = 'Requsst completed succesfully',
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'success' => $this->success,
                'message' => $this->message,
                'data' => $this->data,
            ],
            status: $this->status,
            headers: [],
        );
    }
}

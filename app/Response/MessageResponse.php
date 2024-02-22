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
        private readonly string $message = 'Request completed succesfully',
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return static::buildResponse(
            [
                'success' => $this->success,
                'message' => $this->message,
                'data' => $this->data
            ],
            status: $this->status
        );
    }

    public static function paginated(
        $data,
        int $status = 200,
        bool $success = false,
        string $message = 'Request completed succesfully',
    ) {
        $responseData = $data->response()->getData();

        return static::buildResponse([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'links' => $responseData?->links,
            'meta' => $responseData?->meta,
        ], $status);
    }

    private static function buildResponse($data, $status, array $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }
}

<?php



namespace App\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final class MessageResponse implements Responsable
{
    public function __construct(
        private readonly array $data,
        private readonly int $status = 200,
        private readonly bool $success = false,
        private readonly string $message = 'Request completed succesfully',
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return static::buildResponse(
            [
                'data' => $this->data
            ],
            status: $this->status,
            success: $this->success,
            message: $this->message
        );
    }

    public static function success(
        array $data = [],
        int $status = 200,
        bool $success = true,
        string $message = 'Request completed succesfully'
    ) {
        return static::buildResponse($data, $status, $success, $message);
    }

    public static function error(
        array $data = [],
        int $status = 500,
        bool $success = false,
        string $message = 'Operation failed',
    ) {
        return static::buildResponse($data, $status, $success, $message);
    }

    private static function buildResponse(
        array $data,
        int $status,
        bool $success = false,
        string $message = 'Request completed succesfully',
        array $headers = []
    ) {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            ...$data
        ], $status, $headers);
    }
}

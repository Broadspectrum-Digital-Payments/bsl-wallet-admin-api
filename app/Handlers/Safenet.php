<?php

namespace App\Handlers;

use App\Response\MessageResponse;
use Closure;
use Exception;
use Throwable;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

final class Safenet
{
    public static function run(Closure $fn)
    {
        try {
            return $fn();
        } catch (\Throwable | QueryException $e) {
            report($e);

            if ($e instanceof QueryException) {
                return self::respond(static::toReadable($e->getMessage()));
            }

            return self::processException($e);
        }
    }

    private static function processException(Throwable $e): ?JsonResponse
    {
        if ($e instanceof QueryException) {
            return self::respond(static::toReadable($e->getMessage()));
        }

        if ($e instanceof ConnectionException) {
            return self::respond(static::toReadable("Link can't be reached"));
        }

        if (
            $e instanceof ServerException
            || $e instanceof ErrorException
            || $e instanceof ClientException
            || $e instanceof ConnectException
            || $e instanceof MethodNotAllowedHttpException
            || ($e instanceof Exception && env('APP_DEBUG'))
        ) {
            return self::respond(static::toReadable($e->getMessage()));
        }

        return self::respond();
    }

    private static function respond(
        $msg = 'Something went wrong',
        $status = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return MessageResponse::error(message: $msg, status: $status);
    }

    private static function toReadable(string $msg): string
    {
        $err = json_decode(substr($msg, strpos($msg, '{'))) ?? $msg;

        return property_exists($err, 'message') ? $err->message : $msg;
    }
}

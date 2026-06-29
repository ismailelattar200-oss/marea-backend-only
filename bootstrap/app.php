<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                $msg = is_string($e->getMessage()) ? mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8') : 'Unknown error';
                $payload = [
                    'DEBUG_ERROR' => true,
                    'class' => get_class($e),
                    'message' => $msg,
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
                if ($e instanceof \Illuminate\Database\QueryException) {
                    $payload['sql'] = $e->getSql();
                    $payload['bindings'] = $e->getBindings();
                }
                $json = json_encode($payload, JSON_INVALID_UTF8_SUBSTITUTE);
                return response($json, 200, ['Content-Type' => 'application/json']);
            }
        });
    })->create();

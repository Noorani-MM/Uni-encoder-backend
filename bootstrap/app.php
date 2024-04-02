<?php

use App\Http\Middleware\ForceJSON;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

function error(string $message = '', array|object $errors = [], int $status = 500): \Illuminate\Http\JsonResponse
{
    return response()->json([
        'message' => $message,
        'data'    => [],
        'errors'  => $errors,
        'success' => false,
    ], $status);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Force to use `accept`: `application/json` in api header requests.
        $middleware->appendToGroup('api', [ForceJSON::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, \Illuminate\Http\Request $request) {
            // Check if request is api
           if ($request->is('api/*')) {
               // Check if model not found
               if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                   return error($e->getMessage(), [
                       'model' => $e->getModel(),
                       'ids' => $e->getIds(),
                   ], 404);
               }
               // Check if exception is Global HttpException
               if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                   return error($e->getMessage(), status: $e->getStatusCode());
               }
               // Global exception configuration
               return error($e->getMessage());
           }
        });
    })->create();

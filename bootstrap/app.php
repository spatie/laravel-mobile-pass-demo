<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Spatie\LaravelFlare\Facades\Flare;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => null);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Flare::handles($exceptions);

        /*
         * Livewire stops polling after a 419, while it keeps polling after a 404.
         * Without this, an open tab keeps waking the hibernated app for a pass that was pruned.
         */
        $exceptions->render(function (NotFoundHttpException $exception, Request $request): ?Response {
            if (! $exception->getPrevious() instanceof ModelNotFoundException) {
                return null;
            }

            if (! Livewire::isLivewireRequest()) {
                return null;
            }

            return response()->noContent(419);
        });
    })->create();

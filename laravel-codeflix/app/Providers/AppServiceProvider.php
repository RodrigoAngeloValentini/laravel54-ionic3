<?php

namespace CodeFlix\Providers;

use CodeFlix\Exceptions\SubscriptionInvalidException;
use CodeFlix\Models\Video;
use Dingo\Api\Exception\Handler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Dusk\DuskServiceProvider;
use Tymon\JWTAuth\Exceptions\JWTException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Video::updated(function ($video){

            if(!$video->completed) {
                if($video->file != null && $video->thumb != null && $video->duration != null){
                    $video->completed = true;
                    $video->save();
                }
            }

        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'prod') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind('bootstrapper::form', function ($app){
            $form = new Form(
                $app->make('collective::html'),
                $app->make('url'),
                $app->make('view'),
                $app['session.store']->token()
            );

            return $form->setSessionStore($app['session.store']);
        });

        $handler = app(Handler::class);
        $handler->register(function (AuthenticationException $exception){
            return response()->json(['error' => 'Unauthenticated'], 401);
        });
        $handler->register(function (JWTException $exception){
            return response()->json(['error' => $exception->getMessage()], 401);
        });
        $handler->register(function (ValidationException $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'validation_errors' => $exception->validator->getMessageBag()->toArray()
            ], 422);
        });
        $handler->register(function (SubscriptionInvalidException $exception){
            return response()->json([
                'error' => 'subscription_valid_not_fuound',
                'validation_errors' => $exception->getMessage()
            ], 403);
        });
    }
}

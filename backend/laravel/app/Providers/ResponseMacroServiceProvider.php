<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      ResponseFactory::macro('streamJson',
        function ($data, $status = 200, $headers = [], $encodingOptions = JsonResponse::DEFAULT_ENCODING_OPTIONS) {
        return new StreamedJsonResponse(
            $data,
            $status,
            $headers,
            $encodingOptions
          );
      });

      Response::macro('error', function ($message, $code = 404) {
          return Response::json([
            'success'  => false,
            'message' => $message,
          ], $code);
        });
    }
}

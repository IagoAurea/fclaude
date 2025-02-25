<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Training</title>
        <link rel="stylesheet" href="{{  public_path() . '/css/training.css' }}">
        {{-- Laravel Mix - CSS File --}}
        {{-- <link rel="stylesheet" href="{{ Module::asset('exercise:css/exercise.css') }}">--}}
        {{-- <link rel="stylesheet" href="{{ ltrim(mix('css/exercise.css'), '/') }}"> --}}
    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/training.js') }}"></script> --}}
    </body>
</html>

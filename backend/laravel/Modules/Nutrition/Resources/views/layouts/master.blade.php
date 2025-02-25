<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nutrition</title>
        <link rel="stylesheet" href="{{ ltrim(mix('css/app.css'), '/') }}">
        <style>
            body {
                margin: 120px 0px 0px 0px;
            }

            .pdf-title-test {
                font-family: Arial, Verdana, Tahoma, sans-serif;
                color: #00e9c5;
                text-transform: uppercase;
                font-size: 20px;
                font-weight: 200px;
                padding-left: 20px;
            }

            #header {
                position: fixed;
                top: 7px;
                left: 0px;
            }

            .pdf-image-header {
                width: 750px; 
                position:relative;
                padding: 0px; 
                margin:0px; 
                left:8px;
            }  
            
            .pdf-image-footer {
                width: 300px; 
                position:relative;
                top: 10px;
                margin:0px;
            }  

            #footer {
                position: fixed;
                bottom: 0px;
                left: 0px;
                font-family: Arial, Verdana, Tahoma, sans-serif;
                color: #00e9c5;
                font-size: 15px;
            }
        </style>

       {{-- Laravel Mix - CSS File --}}

    </head>
    <body>
        @include ('test::layouts.header')
        <div class="pdf-content">
            @yield('content')
        </div>
    </body>
</html> {{-- Keep the div, body and html on the same line to avoid a dompdf known problem --}}

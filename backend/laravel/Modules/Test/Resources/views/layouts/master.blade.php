<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test</title>
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

            .pdf-avatar-test {
                position: absolute;
                width: 165px;
                height: 165px;
                top: 120px;
                border-radius: 125px;
                border: 9px solid #00e9c5;
                outline: 5px solid #050C44;
                background-color: #c4c4c4;
                left: 520px;
            }

            .pdf-section-bar-test {
                margin-top: 20px;
                width: 800px;
                padding: 10px 0px 10px 50px;
                background: #050C44;
                color: white;
                font-family: Arial, Verdana, Tahoma, sans-serif;
                font-size: 12px;
                border-top: 5px solid #00e9c5;
            }

            .section-1-right-test {
                text-align: center;
                vertical-align: middle;
                padding-top: 22px;
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
                left: 95px; 
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
        @include ('test::layouts.footer')
        <div class="pdf-content">
            @yield('content')
        </div>
    </body>
</html> {{-- Keep the div, body and html on the same line to avoid a dompdf known problem --}}
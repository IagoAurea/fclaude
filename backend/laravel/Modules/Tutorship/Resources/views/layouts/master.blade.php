<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tutorship</title>
        <link rel="stylesheet" href="{{ ltrim(mix('css/app.css'), '/') }}">
        <style>
            body {
                background: url({{ public_path() . '/images/pdf-banner.png' }}) center top fixed no-repeat;
                border: inset 0.5px transparent;
                margin-top: 5px;
                background-repeat: no-repeat;
                background-size: 97% 8%;
            }

            .pdf-date {
                position: absolute;
                width: 100%;
                bottom: -1px;
                font-family: Arial, Verdana, Tahoma, sans-serif;
                color: #00e9c5;
                font-size: 15px;
                padding-top: 15px;

                background-image: url({{ public_path() . '/images/pdf-bottom-banner.png' }});
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: right;
                background-size: 40% 100%;
            }
        </style>

       {{-- Laravel Mix - CSS File --}}

    </head>
    <body>
        <div class="pdf-content">
            @yield('content')
        </div>
    </body>
</html> {{-- Keep the div, body and html on the same line to avoid a dompdf known problem --}}

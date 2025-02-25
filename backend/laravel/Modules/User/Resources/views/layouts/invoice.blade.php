<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User</title>
        <link rel="stylesheet" href="{{  public_path() . '/css/invoice.css' }}">
    </head>
    <body>
        <header style="position: fixed; left: 0px; right: 0px; top: 4px;">
            <img src="{{ public_path() . '/images/pdf-banner.png'}}" alt="header" class="pdf-image-header">
        </header>

        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/user.js') }}"></script> --}}

        <footer class="pdf-footer">
            <div style="padding-left:178px;width: 100%;">
                <span style="padding-right: 30px; color: #00e9c5; letter-spacing: 5px; font-size: 20px;">
                    @lang('user::messages.invoice_generated')
                </span>
                <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}"
                    style="width: 380px; position:relative; right: 42px; top: 10px;" alt="footer"
                >
            </div>
        </footer>
    </body>
</html>

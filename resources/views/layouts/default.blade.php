<html lang="en">
<head>
    <!-- ==============================================
		            Title and Meta Tags
	=============================================== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME', 'ThemePark') }}</title>

    <!-- ==============================================
		                  Favicon
	=============================================== -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-16x16.png') }}" sizes="16x16" />

    <!-- ==============================================
                         CSS Files
    =============================================== -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

@yield('body')

<footer class="footer">
    <div class="container">
        <span>Copyright &copy; 2019-{{ date('Y') }} <a href="https://www.iobyte.nl/"><img src="{{ asset('assets/img/logo.png') }}" alt="IOByte"></a>. All rights reserved.</span>
    </div>
</footer>

<!-- ==============================================
                      JS Files
=============================================== -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
@yield('javascript')
</body>
</html>


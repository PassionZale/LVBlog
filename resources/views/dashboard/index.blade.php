<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="csrf-token" content="{{ csrf_token() }}">

        <title>Lei's Blog</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Markdown -->
        <link href="{{ asset('css/markdown.css') }}" rel="stylesheet">

    </head>
    <body>


        <script>
            @if (Auth::user())
                    const USER = {!! Auth::user() !!};
            USER.isLogin = true;
                    @ else
                    const USER = {isLogin: false}
            @endif
        </script>
        <!-- JavaScripts -->
        <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
        <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/lib/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/lib/html5ImgCompress/dist/html5ImgCompress.min.js') }}"></script>
        <!--<script src="{{ asset('js/lib/markdown.min.js') }}"></script>-->
        <script src="https://cdn.bootcss.com/showdown/1.3.0/showdown.min.js"></script>
        <script src="{{ asset('js/build/app.js') }}"></script>

    </body>
</html>

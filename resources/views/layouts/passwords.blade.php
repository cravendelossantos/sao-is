<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title')</title>

        @section('css')
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="/css/animate.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/mystyle.css" rel="stylesheet">
        @show
    </head>

    <body class="gray-bg">


    <div class="wrapper wrapper-content">
                    @yield('content')

    </div>
    
                            <hr/>
               <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center fixed">
                Lyceum of the Philippines University - Cavite
                <br>
                <small>&copy; 2016 - {{ Carbon\Carbon::now()->format('Y') }}</small>
            </div>
            
        </div>
    </body>
    </html>
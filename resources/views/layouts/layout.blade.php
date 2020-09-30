<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Interview Management System</title>
    <link rel="icon" type="image/gif/png" href="{{ URL::asset('public/images/MB2.png') }}">
        {{ HTML::script(asset('public/js/jquery.min.js')) }}
        {{ HTML::style(asset('public/css/header.min.css')) }}
        {{ HTML::style(asset('public/css/headerfooter.min.css')) }}
        {{ HTML::script(asset('public/js/bootstrap.min.js')) }}
        {{ HTML::script(asset('public/js/jquery.plugin.js')) }}
        {{ HTML::style(asset('public/css/bootstrap.min.css')) }}
    </head>
<body>
    @yield('content')
</body>
</html>

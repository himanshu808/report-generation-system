<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{asset('css/app.css')}}">
        <title>Laravel</title>

        
    </head>
    <body>
    	@include('include.navbar')
        @include('include.messages')
        @yield('content')
    </body>
</html>

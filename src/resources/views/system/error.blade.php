<?php
$paragraphs = $paragraphs ?? [];
?>
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <title>Article Assistant 404</title>
    @include('bootstrap.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="{{asset('js/app.js')}}"></script>
</head>
<body class="antialiased bg-light">
@include('icons.svg')
<h1>Oops something went wrong!</h1>
@include('system.notifications');
@include('bootstrap.js')
</body>
</html>

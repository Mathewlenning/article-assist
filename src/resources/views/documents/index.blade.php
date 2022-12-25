<?php
    $paragraphs = $paragraphs ?? [];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <title>Article Assistant</title>
    @include('bootstrap.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="{{asset('js/app.js')}}"></script>
</head>
<body class="antialiased bg-dark">
@include('icons.svg')
<div class="position-fixed bg-light absolute-screen"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col pt-4">
            <form id="document-form" class="js-parent-container">
            <ul id="js-sortable-paragraphs" class="list-group js-sort-group">
                @include('document.form')
            </ul>
            <div class="d-flex justify-content-center pt-2">
                <a href="javascript:void(0)" onclick="addInput(event)" data-route="paragraph">
                    <svg>
                        <use href="#icon-plus"/>
                    </svg>
                </a>
            </div>
                @csrf
            </form>
        </div>
        <div class="col p-4 d-flex justify-content-center text-left text-light js-preview-container">
            @include('document.preview')
        </div>
    </div>
</div>
@include('bootstrap.js')
@include('sortable.js')
</body>
</html>

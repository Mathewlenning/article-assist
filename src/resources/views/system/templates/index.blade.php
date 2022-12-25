<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null $model
 * @var Illuminate\Http\Request $request
 * @var App\Http\Controllers\ $config
 * @var App\Services\SystemNotifications\MessageQueue $msgQue
 * @var ?string $page_title
 * @var ?string $body_class
 * @var ?string $additionalMetaTemplate
 * @var ?string $headerTemplate
 * @var string $bodyTemplate
 * @var ?string $footerTemplate
 * @var ?string $additionalScripts
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('system.meta')
    @if(!empty($additionalMetaTemplate))
        @include($additionalMetaTemplate)
    @endif
    <title>{{$page_title}}</title>
    @include('bootstrap.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="{{asset('js/app.js')}}"></script>
</head>
<body class="antialiased {{$body_class}}">
@include('icons.svg')
@if(!empty($headerTemplate))
    @include($headerTemplate)
@endif
@if($msgQue->has())
    @include('system.notifications')
@endif
@include($bodyTemplate)
@if(!empty($footerTemplate))
    @include($footerTemplate)
@endif

@include('bootstrap.js')
@if(!empty($additionalScripts))
    @include($additionalScripts)
@endif
</body>
</html>

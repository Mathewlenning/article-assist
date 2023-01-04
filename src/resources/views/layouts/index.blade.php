<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null             $model
 * @var Illuminate\Http\Request                             $request
 * @var App\Services\Mvsc\Controllers\                      $config
 * @var \App\Services\Mvsc\SystemNotifications\MessageQueue $msgQue
 * @var ?string                                             $page_title
 * @var ?string                                             $body_class
 * @var ?string                                             $additionalMetaTemplate
 * @var ?string                                             $headerTemplate
 * @var string                                              $bodyTemplate
 * @var ?string                                             $footerTemplate
 * @var ?string                                             $additionalScriptsTemplate
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
    @include('assets.bootstrap.css')
    @include('assets.app.css')
    @include('assets.jquery.js')
    @include('assets.app.js')
</head>
<body class="antialiased {{$body_class}}">
@include('assets.icons.svg')
@if(!empty($headerTemplate))
    @include($headerTemplate)
@endif
@include($bodyTemplate)
@if(!empty($footerTemplate))
    @include($footerTemplate)
@endif

@include('assets.bootstrap.js')
@if(!empty($additionalScriptsTemplate))
    @include($additionalScriptsTemplate)
@endif
</body>
</html>

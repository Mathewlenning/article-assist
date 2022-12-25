<?php
/**
 * @var Illuminate\Http\Request $request
 */
$paragraphs = $request->input('document', [['primary_argument' => '', 'supporting_arguments' => []]]);
$index = $request->input('index', 0);
?>
@foreach($paragraphs AS $index => $paragraph)
@include('document.forms.paragraph')
@endforeach
@if(empty($paragraphs))
    @include('document.forms.paragraph')
@endif

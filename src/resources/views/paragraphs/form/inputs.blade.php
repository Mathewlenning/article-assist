<?php
/**
 * @var Illuminate\Http\Request $request
 */
$paragraphs = $request->input('document', [['primary_argument' => '', 'supporting_arguments' => []]]);
$index = $request->input('index', 0);
?>
@foreach($paragraphs AS $index => $paragraph)
    @include('paragraphs.form.inputs.paragraph')
@endforeach
@if(empty($paragraphs))
    @include('paragraphs.form.inputs.paragraph')
@endif


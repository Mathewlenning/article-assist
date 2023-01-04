<?php
/**
 * @var array                                   $paragraphs
 * @var \App\Services\Mvsc\Requests\MvscRequest $request
 */
$paragraphs = $paragraphs ?? $request->input('documents', [['primary_argument' => '', 'supporting_arguments' => []]]);
$oldIndex = $request->input('index', 0);
?>
@foreach($paragraphs AS $index => $paragraph)
		<?php $index += $oldIndex; ?>
    @include('paragraphs.form.inputs.paragraph')
@endforeach
@if(empty($paragraphs))
    @include('paragraphs.form.inputs.paragraph')
@endif

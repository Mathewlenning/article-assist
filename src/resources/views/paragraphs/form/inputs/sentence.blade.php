<?php
$supporting_argument = $supporting_argument ?? '';
$index = $index ?? 0;

if (!isset($canDelete)) {
	$canDelete = false;
}
?>

<div class="row mt-1 js-parent-container">
    <div class="col">
        <div class="input-group">
            @include('paragraphs.form.inputs.sort')
            <input type="text"
                   name="document[paragraphs][{{$index}}][supporting_arguments][]"
                   value="{{$supporting_argument}}"
                   class="form-control"
                   placeholder="Supporting Argument"
                   onkeyup="refreshPreview()"/>
            @include('paragraphs.form.inputs.delete')
        </div>
    </div>
</div>

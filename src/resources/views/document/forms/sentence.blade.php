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
            @include('document.controls.sort')
            <input type="text"
                   name="document[paragraphs][{{$index}}][supporting_arguments][]"
                   value="{{$supporting_argument}}"
                   class="form-control"
                   placeholder="Supporting Argument"
                   onkeyup="refreshPreview()"/>
            @include('document.controls.delete')
        </div>
    </div>
</div>

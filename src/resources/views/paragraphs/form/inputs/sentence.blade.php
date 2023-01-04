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
                   name="documents[paragraphs][{{$index}}][supporting_arguments][]"
                   value="{{$supporting_argument}}"
                   class="form-control"
                   data-view-template="paragraphs.form.inputs.sentence"
                   placeholder="Supporting Argument"
                   onkeyup="article_assist.keyboard.dispatch(event)"/>
        </div>
    </div>
</div>

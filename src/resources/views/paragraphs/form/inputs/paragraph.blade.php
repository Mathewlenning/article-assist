<?php
/**
 * @var \App\Models\Paragraphs|array            $paragraph
 * @var \App\Services\Mvsc\Requests\MvscRequest $request
 */
$paragraph = $paragraph ?? ['primary_argument' => '', 'supporting_arguments' => []];
$index = $request->input('index', 0);
?>
<li class="list-group-item p-1 js-parent-container">
    <div class="row">
        <div class="col">
            <div class="input-group">
                @include('paragraphs.form.inputs.sort')
                <input type="text"
                       name="documents[paragraphs][{{$index}}][primary_argument]"
                       value="{{$paragraph['primary_argument']}}"
                       class="form-control"
                       data-view-template="paragraphs.form.inputs"
                       onfocusin="article_assist.documents.showSupportingArguments(event)"
                       onkeyup="article_assist.keyboard.dispatch(event)"
                       placeholder="Primary Argument"
                />
            </div>
        </div>
    </div>
    <div class="js-accordion collapse mt-2 pt-2 border-top border-secondary">
        <div class="js-sort-group js-sortable-sentences">
            @foreach($paragraph['supporting_arguments'] AS $count => $supporting_argument)
                @include('paragraphs.form.inputs.sentence')
            @endforeach
            @if(empty($paragraph['supporting_arguments']))
                @include('paragraphs.form.inputs.sentence')
            @endif
        </div>
    </div>
</li>


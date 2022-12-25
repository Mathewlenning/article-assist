<?php
$paragraphs = $paragraphs ?? ['primary_argument' => '', 'supporting_arguments' => []];
$index = $request->input('index', 0);
    ?>
<li class="list-group-item p-1 js-parent-container">
    <div class="row">
        <div class="col">
            <div class="input-group">
                @include('document.controls.sort')
                <input type="text"
                       name="document[paragraphs][{{$index}}][primary_argument]"
                       value="{{$paragraph['primary_argument']}}"
                       class="form-control"
                       onfocusin="showSupportingArguments(event);"
                       onkeyup="refreshPreview()"
                       placeholder="Primary Argument"
                />
                @include('document.controls.delete')
            </div>
        </div>
    </div>
    <div class="js-accordion collapse mt-2 pt-2 border-top border-secondary">
        <div class="js-sort-group js-sortable-sentences">
            @foreach($paragraph['supporting_arguments'] AS $count => $supporting_argument)
                @include('document.forms.sentence')
            @endforeach
            @if(empty($paragraph['supporting_arguments']))
                @include('document.forms.sentence')
            @endif
        </div>
        <div class="p-2 text-right">
            <a href="javascript:void(0)" class="btn btn-light btn-sm" onclick="addInput(event)" data-view="document.forms.sentence">
                <svg>
                    <use href="#icon-plus"/>
                </svg>
            </a>
        </div>
    </div>
</li>

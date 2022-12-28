<?php
/**
 * @var App\Models\Documents $model
 */
?>
<div class="position-fixed bg-light absolute-screen"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col pt-4">
            <form id="document-form" class="js-parent-container">
            <div class="row mb-1">
                <div class="col">
                    <input type="text" name="document[title]" class="form-control" placeholder="Title" value="{{$model->title}}"/>
                </div>
            </div>
                <div class="row">
                    <div class="col">
                        <ul id="js-sortable-paragraphs" class="list-group js-sort-group">
                            @include('paragraphs.form.inputs')
                        </ul>
                        <div class="d-flex justify-content-center pt-2">
                            <a href="javascript:void(0)" onclick="addInput(event)" data-view-template="paragraphs.form.inputs">
                                <svg>
                                    <use href="#icon-plus"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="document[document_id]" value="{{$model->document_id}}"/>
                <?php $method = empty($model->document_id) ? 'POST': 'PUT';?>
                @method($method)
                @csrf
            </form>
        </div>
        <div class="col p-4 d-flex justify-content-center text-left text-light js-preview-container">
            @include('documents.form.preview')
        </div>
    </div>
</div>

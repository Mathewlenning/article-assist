<div class="position-fixed bg-light absolute-screen"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col pt-4">
            <form id="document-form" class="js-parent-container">
            <ul id="js-sortable-paragraphs" class="list-group js-sort-group">
                @include('document.forms.main')
            </ul>
            <div class="d-flex justify-content-center pt-2">
                <a href="javascript:void(0)" onclick="addInput(event)" data-view="document.forms.main">
                    <svg>
                        <use href="#icon-plus"/>
                    </svg>
                </a>
            </div>
                @csrf
            </form>
        </div>
        <div class="col p-4 d-flex justify-content-center text-left text-light js-preview-container">
            @include('document.preview')
        </div>
    </div>
</div>

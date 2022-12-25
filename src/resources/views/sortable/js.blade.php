<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script>
    function makeSortable() {
        $('#js-sortable-paragraphs').sortable({
                handle: '.js-sortable-handle',
                animation: 150,
                onEnd: (event) => {refreshDocument();}
            }
        );

        $('.js-sortable-sentences').sortable({
                handle: '.js-sortable-handle',
                animation: 150,
            onEnd: (event) => {refreshPreview();}
            }
        );
    }
    makeSortable();
</script>

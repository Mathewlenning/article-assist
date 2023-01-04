<?php
$page_title = 'Article Assistant - Edit Document';
$body_class = 'bg-dark';
$bodyTemplate = 'documents.form.body';
$additionalScriptsTemplate = 'assets.sortable.js';
?>

@include('layouts.index')

<script>
    jQuery(document).ready(function () {
        article_assist.documents.initSortable();
    })
</script>

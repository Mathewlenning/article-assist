<?php
/**
/**
 * @var Illuminate\Database\Eloquent\Model|null             $model
 * @var Illuminate\Http\Request                             $request
 * @var App\Services\Mvsc\Controllers\                      $config
 * @var \App\Services\Mvsc\SystemNotifications\MessageQueue $msgQue
 */

$page_title = 'Article Assistant - Edit Document';
$body_class = 'bg-dark';
$bodyTemplate = 'documents.form.body';
$additionalScriptsTemplate = 'assets.sortable.js';
?>

@include('layouts.index')

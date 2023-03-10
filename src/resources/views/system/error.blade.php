<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null             $model
 * @var Illuminate\Http\Request                             $request
 * @var App\Services\Mvsc\Controllers\                      $config
 * @var \App\Services\Mvsc\SystemNotifications\MessageQueue $msgQue
 * @var ?string                                             $page_title
 * @var ?string                                             $body_class
 * @var ?string                                             $additionalMetaTemplate
 * @var ?string                                             $headerTemplate
 * @var string                                              $bodyTemplate
 * @var ?string                                             $footerTemplate
 * @var ?string                                             $additionalScriptsTemplate
 */

$page_title = 'Article Assistant - Error';
$body_class = 'bg-dark text-light';
$bodyTemplate = 'system.error.body';
?>
@include('layouts.index')

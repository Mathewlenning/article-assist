<?php
$typeClassMap = [
	'messages' => 'alert-primary',
    'errors' => 'alert-danger',
    'warnings' => 'alert-warning',
    'success' => 'alert-success',
    'info' => 'alert-info',
    'light' => 'alert-light',
    'dark' => 'alert-dark'
]
/** @var App\Http\Controllers\Config $config */
/** @var App\Services\SystemNotifications\MessageQueue $msgQue */
?>
@if($msgQue->has())
    @foreach($msgQue->getMessages() AS $type => $messages)
        <?php $className = (array_key_exists($type, $typeClassMap))
            ? $typeClassMap[$type]
            : $config->get('app.default_notification_type');?>

        <div class="alert {{$className}}">
            @foreach($messages AS $message)
                <p>{{$message}}</p>
            @endforeach
        </div>
    @endforeach
@endif

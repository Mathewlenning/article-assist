<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null $model
 * @var Illuminate\Http\Request $request
 * @var App\Http\Controllers\ $config
 * @var App\Services\SystemNotifications\MessageQueue $msgQue
 */
$document = $request->input('document', ['paragraphs' => []]);
$hasParagraphs = false;
?>
<div class="col text-light bg-dark lead">
    @foreach ($document['paragraphs'] as $paragraph)
        <?php $hasParagraphs = true;?>
        <p>
            {{$paragraph['primary_argument']}}
            @foreach($paragraph['supporting_arguments'] AS $sentence)
                {{ ' ' . $sentence }}
            @endforeach
        </p>
    @endforeach
    @if(!$hasParagraphs)
            <p class="text-light lead">Use the left panel to add text.</p>
    @endif
</div>


<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null $model
 * @var App\Services\Mvsc\Requests\MvscRequest  $request
 */
$paragraphs = $request->input('document')['paragraphs'] ?? $model->paragraphs();
$hasParagraphs = false;
?>
<div class="col text-light bg-dark lead">
    @foreach ($paragraphs as $paragraph)
			<?php
			$hasParagraphs = true;
			if (!is_array($paragraph))
			{
				$paragraph = $paragraph->toArray();
			}
			?>

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


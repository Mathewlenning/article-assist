<?php

namespace App\Models;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int paragraph_id
 * @property int document_id
 * @property string primary_argument
 * @property string[] supporting_arguments
 * @property string created_at
 * @property string updated_at
 *
 */
class Paragraphs extends MvscBase
{
    protected $fillable = [
        'document_id',
        'order',
        'primary_argument',
        'supporting_arguments'
    ];

    use Eloquent\Factories\HasFactory;

    public function Document(): Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            Documents::class,
            'document_id',
            'document_id')
            ->withDefault();
    }

    public function getFormValidationRules(?array $additionalRules = []): array
    {
        return [
            'paragraph_id'=> 'integer',
            'document_id' => 'integer',
            'primary_argument' => 'required_unless:paragraph_id, null|string|nullable',
            'supporting_arguments.*' => 'string|nullable'
        ] + $additionalRules;
    }

    protected function supportingArguments(): Attribute {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent;

/**
 * @property int paragraph_id
 * @property int document_id
 * @property string primary_argument
 * @property string[] supporting_arguments
 * @property string created_at
 * @property string updated_at
 *
 */
class Paragraph extends Base
{
    protected $fillable = [
        'document_id',
        'primary_argument',
        'supporting_arguments'
    ];

    use Eloquent\Factories\HasFactory;

    public function Document(): Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            Document::class,
            'document_id',
            'document_id')
            ->withDefault();
    }

    public static function getFormValidationRules(?array $additionalRules = []): array
    {
        return [
            'document_id' => 'required|integer',
            'primary_argument' => 'require_unless:paragraph_id, null|string|nullable',
            'supporting_arguments' => 'array',
            'supporting_arguments.*' => 'string|nullable'
        ] + $additionalRules;
    }
}

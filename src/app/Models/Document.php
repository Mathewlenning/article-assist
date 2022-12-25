<?php

namespace App\Models;

use Illuminate\Database\Eloquent;

/**
 * @property int document_id
 * @property int $user_id
 * @property string $title
 * @property string created_at
 * @property string updated_at
 *
 */
class Document extends Base
{
    use Eloquent\Factories\HasFactory;

    protected $primaryKey = 'document_id';

    protected $fillable = [
        'user_id',
        'title'
    ];

    public function owner(): Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        )->withDefault(['name' => 'Guest']);
    }

    public function paragraphs(): Eloquent\Relations\HasMany
    {
        return $this->hasMany(Paragraph::class);
    }

    public static function getFormValidationRules(?array $additionalRules = []): array
    {
        return [
            'document_id' => 'required|integer',
            'user_id' => 'require_unless:document_id, null|int',
            'title' => 'require_unless:document_id, null|string'
        ] + $additionalRules;
    }
}

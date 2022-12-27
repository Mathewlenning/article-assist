<?php

namespace App\Models;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Database\Eloquent;

/**
 * @property int document_id
 * @property int $user_id
 * @property string $title
 * @property string created_at
 * @property string updated_at
 */
class Documents extends MvscBase
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
        return $this->hasMany(Paragraphs::class);
    }

    public function getFormValidationRules(?array $additionalRules = []): array
    {
        $baseRules = [
                'document.document_id' => 'integer',
                'document.user_id' => 'required_unless:document_id,null|integer',
                'document.title' => 'required_unless:document_id,null|string'
        ];

        $paragraphRules = $this->paragraphs()->getModel()->getFormValidationRules();

        foreach ($paragraphRules AS $key => $rule){
            $baseRules['document.paragraphs.*.' . $key] = $rule;
        }

        return $baseRules + $additionalRules;
    }
}

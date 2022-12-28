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
        'title'
    ];

    public function owner(): Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        )->withDefault(['user_id' => 0,'name' => 'Guest']);
    }

    public function paragraphs(): Eloquent\Relations\HasMany
    {
        return $this->hasMany(Paragraphs::class);
    }

    public function getFormValidationRules(?array $additionalRules = []): array
    {
        $return = [
                'document_id' => 'integer',
                'user_id' => 'integer',
                'title' => 'required_unless:document_id,null|string',
                'paragraphs' => 'array'
        ] + $additionalRules;
    }

    public function getFormInputName(): string
    {
        return 'document';
    }

    public function createDependents(array $attributes = []): static {
        if (empty($this->document_id)
            || empty($attributes['paragraphs'][0]['primary_argument'])
        ){
            return $this;
        }

        $paragraphsModel = $this->paragraphs()->getModel();

        foreach ($attributes['paragraphs'] AS $index => $paragraph)
        {
            $paragraph['document_id'] = $this->document_id;
            $paragraph['order'] = $index + 1;
            $paragraphsModel->create($paragraph);
        }

        return $this;
    }
}

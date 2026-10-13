<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menu';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'label',
        'url',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'parent_id' => 'integer',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            Menu::class,
            'parent_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            Menu::class,
            'parent_id'
        )->orderBy('urutan');
    }
}
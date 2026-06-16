<?php

namespace App\Models;

use Database\Factories\MarketingTaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MarketingTask extends Model
{
    /** @use HasFactory<MarketingTaskFactory> */
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'status',
        'image_path',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function getReferenceUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}

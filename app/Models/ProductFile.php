<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'storage_disk',
        'storage_path',
        'display_name',
        'format',
        'file_size',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function downloadEvents(): HasMany
    {
        return $this->hasMany(DownloadEvent::class);
    }
}

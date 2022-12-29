<?php

namespace App\Models;

use App\Models\Kost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'parking',
        'bathroom',
        'security',
        'table',
        'chair',
        'cupboard',
        'bed'
    ];

    /**
     * Get the kost that owns the Facility
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }
}

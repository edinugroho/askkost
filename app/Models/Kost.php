<?php

namespace App\Models;

use App\Models\Owner;
use App\Models\Facility;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'location',
        'type',
        'price'
    ];

    /**
     * Get the owner that owns the Kost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the facility associated with the Kost
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function facility(): HasOne
    {
        return $this->hasOne(Facility::class);
    }

    /**
     * Get all of the questions for the Kost
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}

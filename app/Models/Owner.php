<?php

namespace App\Models;

use App\Models\Kost;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    /**
     * Get all of the kosts for the Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kosts(): HasMany
    {
        return $this->hasMany(Kost::class);
    }

    /**
     * Get all of the questions for the Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}

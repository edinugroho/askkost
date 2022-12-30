<?php

namespace App\Models;

use App\Models\Kost;
use App\Models\Question;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Owner extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
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

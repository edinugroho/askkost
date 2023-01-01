<?php

namespace App\Services;

use App\Models\Kost;
use App\Models\Question;
use Spatie\QueryBuilder\QueryBuilder;

class KostService 
{
    public function __construct() {
        $this->kost = app(Kost::class);
        $this->question = app(Question::class);
    }

    public function all()
    {
        return QueryBuilder::for($this->kost)
            ->with('facility')
            ->allowedFilters(['name', 'location', 'price'])
            ->allowedSorts('price')
            ->get();
    }

    public function byOwner($id)
    {
        return QueryBuilder::for($this->kost->where('owner_id', $id))
            ->with('facility')
            ->with('questions')
            ->allowedFilters(['name', 'location', 'price', 'questions.status'])
            ->allowedSorts('price')
            ->get();
    }

    public function byUser($id)
    {
        return QueryBuilder::for($this->question->where('user_id', $id))
            ->with('kost')
            ->allowedFilters(['kost.name', 'kost.location', 'kost.price', 'status'])
            ->allowedSorts('price')
            ->get();
    }
}

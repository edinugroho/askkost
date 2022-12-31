<?php

namespace App\Services;

use App\Models\Kost;
use Spatie\QueryBuilder\QueryBuilder;

class KostService 
{
    public function __construct() {
        $this->kost = app(Kost::class);
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
}

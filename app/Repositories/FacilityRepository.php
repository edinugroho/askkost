<?php

namespace App\Repositories;

use App\Models\Facility;

class FacilityRepository
{
    public function __construct() {
        $this->facility = app(Facility::class);
    }

    public function save($data)
    {
        $this->facility['kost_id'] = $data['kost_id'];
        $this->facility['parking'] = $data['parking'];
        $this->facility['bathroom'] = $data['bathroom'];
        $this->facility['security'] = $data['security'];
        $this->facility['table'] = $data['table'];
        $this->facility['chair'] = $data['chair'];
        $this->facility['cupboard'] = $data['cupboard'];
        $this->facility['bed'] = $data['bed'];

        return $this->facility->save();
    }
}

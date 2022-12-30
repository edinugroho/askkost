<?php

namespace App\Repositories;

use App\Models\Kost;

class KostRepository
{
    public function __construct() {
        $this->kost = app(Kost::class);
    }

    public function save($data)
    {
        $this->kost['owner_id'] = $data['owner_id'];
        $this->kost['name'] = $data['name'];
        $this->kost['location'] = $data['location'];
        $this->kost['type'] = $data['type'];
        $this->kost['price'] = $data['price'];

        return $this->kost->save();
    }
}

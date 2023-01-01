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

    public function update($data, $id)
    {
        $kost = $this->kost->findOrFail($id);

        return $kost->update($data);
    }

    public function findByid($id)
    {
        return $this->kost->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->kost->findOrFail($id)->delete();
    }
}

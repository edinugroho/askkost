<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository 
{
    public function __construct() {
        $this->question = app(Question::class);
    }

    public function ask($data)
    {
        $this->question['kost_id'] = $data['kost_id'];
        $this->question['user_id'] = $data['user_id'];
        $this->question['owner_id'] = $data['owner_id'];
        $this->question['status'] = $data['status'];

        return $this->question->save();
    }
}
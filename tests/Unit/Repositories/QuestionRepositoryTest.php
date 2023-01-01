<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Kost;
use App\Models\User;
use App\Models\Owner;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Owner::factory()->create();
        Kost::factory()->create();
        User::factory()->create();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_save_question()
    {
        $data = Question::factory()->make(['status' => 'asked']);

        app(QuestionRepository::class)->ask($data);

        $this->assertDatabaseHas('questions', [
            'status' => 'asked'
        ]);
    }

    public function test_can_update_answer_of_question()
    {
        Question::factory()->create(['status' => 'asked']);

        $data = [
            'question_id' => Question::all()->random()->id,
            'available' => 'yes',
            'status' => 'answered'
        ];
        
        app(QuestionRepository::class)->answer($data);

        $this->assertDatabaseHas('questions', [
            'status' => 'answered'
        ]);
    }
}

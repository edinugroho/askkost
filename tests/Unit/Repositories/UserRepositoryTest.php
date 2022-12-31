<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_user()
    {
        $user = User::factory()->make();

        app(UserRepository::class)->save($user);

        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);
    }

    public function test_it_regular_user_given_20_credits()
    {
        $user = User::factory()->make([
            'type' => 'regular'
        ]);

        app(UserRepository::class)->save($user);

        $this->assertDatabaseHas('users', [
            'type' => 'regular',
            'credit' => 20
        ]);
    }
    
    public function test_it_premium_user_given_40_credits()
    {
        $user = User::factory()->make([
            'type' => 'regular'
        ]);

        app(UserRepository::class)->save($user);

        $this->assertDatabaseHas('users', [
            'type' => 'regular',
            'credit' => 20
        ]);
    }

    public function test_can_find_user_by_email()
    {
        $user = User::factory()->make([
            'email' => 'email@mail.co'
        ]);
        $user->save();

        $result = app(UserRepository::class)->find($user->email);

        $this->assertModelExists($result);
    }

    public function test_can_find_user_by_id()
    {
        User::factory()->create([
            'id' => 1
        ]);

        $result = app(UserRepository::class)->findById(1);

        $this->assertModelExists($result);
    }
    
    public function test_can_decrease_user_credit_by_id()
    {
        User::factory()->create([
            'id' => 1,
            'type' => 'regular'
        ]);

        $result = app(UserRepository::class)->decreaseCreditById(1);

        $this->assertDatabaseHas('users', [
            'credit' => 15
        ]);
    }
}

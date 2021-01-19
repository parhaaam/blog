<?php

namespace Tests\Feature;

use App\SMSToken;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\Exception;

class RegisterTest extends TestCase
{
    use WithoutMiddleware,RefreshDatabase;

    public function test_user_can_not_register_without_name()
    {
        $response = $this->json('POST','/register',[
            'email' => 'admin@test.com',
            'password' =>  '12345678',
            'password_confirmation' =>  '12345678',
        ]);
        // dd(json_decode($response->baseResponse->getContent(),JSON_UNESCAPED_UNICODE));
        $response->assertStatus(422);
    }

    public function test_user_can_can_not_register_with_invalid_password_confirmation()
    {
        $response = $this->json('POST','/register',[
            'email' => 'admin@test.com',
            'name' =>  'test',
            'password' =>  '12345678',
            'password_confirmation' =>  '1234567',
        ]);
        $response->assertStatus(422);
    }

    public function test_user_can_can_register_with_valid_data()
    {
        $user = factory(User::class)->create([
            'name' => 'معین',
            'email' => 'moein@test.com',
            'password' => bcrypt($password = 'p12345678'),
        ]);

        $response = $this->json('POST','/register',[
            'email' => 'admin@test.com',
            'name' =>  'test',
            'password' =>  '12345678',
            'password_confirmation' =>  '12345678',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'admin@test.com',
            'name' =>  'test',
        ]);
    }
    
}

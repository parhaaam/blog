<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Exception;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Session;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // public function setUp():void
    // {
    //     parent::setUp();

    //     // Avoid "Session store not set on request." - Exception!
    //     Session::setDefaultDriver('array');
    //     $this->manager = app('session');
       
    // }

    

    public function test_user_can_not_login_without_email()
    {
        $response = $this->json('POST','/login',[
            'password' =>  '12345678',
        ]);
        $response->assertStatus(422);
    }

    public function test_user_can_not_login_with_invalid_data()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'admin@test.com',
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->json('POST','/login',[
            'email' => 'admin@test.com',
            'password' =>  '123456780',
        ]);
        $response->assertStatus(422);
    }

    public function test_user_can_login_with_valid_data()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'admin@test.com',
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->json('POST','/login',[
            'email' => 'admin@test.com',
            'password' =>  '12345678',
        ]);
        // dd(json_decode($response->baseResponse->getContent(),JSON_UNESCAPED_UNICODE));
        $response->assertStatus(204);
    }

    
}

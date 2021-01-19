<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Exception;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    

    public function test_users_can_not_see_without_login()
    {
        $response = $this->json('GET','/admin/users');
        $response->assertStatus(401);
    }

    public function test_users_can_not_see_without_admin_user()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'admin@test.com',
            'password' => bcrypt($password = '12345678'),
            'role' => 2, //no admin user
        ]);

        Auth::setUser($user);

        $response = $this->json('GET','/admin/users');
        $response->assertStatus(403);
    }



    public function test_users_can_see_with_admin_user()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'admin@test.com',
            'password' => bcrypt($password = '12345678'),
            'role' => 3, //no admin user
        ]);

        Auth::setUser($user);

        $response = $this->json('GET','/admin/users');
        $response->assertStatus(200);
    }



    public function test_admin_can_create_user()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'admin@test.com',
            'password' => bcrypt($password = '12345678'),
            'role' => 3, //no admin user
        ]);

        Auth::setUser($user);

        $response = $this->json('POST','/admin/user',[
            'name' => 'new user',
            'email' => 'newuser@test.com',
            'password' =>  '12345678',
            'password_confirmation' =>  '12345678',
            'role' =>  '1',
        ]);
        // dd(json_decode($response->baseResponse->getContent(),JSON_UNESCAPED_UNICODE));
        $response->assertStatus(302);
    }
    
}

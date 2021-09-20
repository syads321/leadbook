<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\User;



class UserRegister extends TestCase
{
    public $data = [
        'name' => 'User Test',
        'email' => 'usertest@yahoo.com',
        'password' => 'user123yahoo',
        'phonenumber' => '08526777299'
    ];

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserRegister()
    {
        User::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => Hash::make($this->data['password']),
            'phonenumber' => $this->data['phonenumber']
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->data['email'],
        ]);
    }
}

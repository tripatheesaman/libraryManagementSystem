<?php

namespace Tests\Unit;

use App\Contracts\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Services\UserAuthService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserAuthServiceTest extends TestCase
{
  use RefreshDatabase;

  //check if user registration is successful
  public function testIfUserRegistersSuccessfully()
  {
   //Mock the Request object with registration data
   $mockRequest = Mockery::mock(Request::class);
   $mockRequest->shouldReceive('all')->andReturn([
       'email' => 'sth@gmail.com',
       'password' => 'password123',
       'role' => 'user',
       'first_name' => 'John',
       'last_name' => 'Doe',
   ]);

   $mockInterface = Mockery::mock(UserInterface::class);
   $mockInterface->shouldReceive('createUser')->once()->andReturn(true);

   $userAuthService = new UserAuthService($mockInterface);
   $isRegistered = $userAuthService->register($mockRequest);
   $this->assertTrue($isRegistered);
  }
  public function testIfUserRegistrationFailsForInvalidInputs()
{
    $mockRequest = Mockery::mock(Request::class);
    $mockRequest->shouldReceive('all')->andReturn([
      'email' => 'sth@gmail.com',
      'password' => 'password123',
      'role' => 'shit',
      'first_name' => 'John',
      'last_name' => 'Doe',
  ]);

    $mockInterface = Mockery::mock(UserInterface::class);
    $mockInterface->shouldReceive('createUser')->once()->andReturn(false);

    //Create the UserAuthService and try to register
    $userAuthService = new UserAuthService($mockInterface);
    $isRegistered = $userAuthService->register($mockRequest);
    //Assert that registration failed
    $this->assertFalse($isRegistered);
}

// public function testUserLogin()
// {
//     // Mock User Model
//     $userMock = $this->createMock(User::class);
//     $userMock->id = 123; // Set a valid user ID
//     $userMock->password = 'password'; // Set a hashed password
    
//     // Mock User Service
//     $userServiceMock = $this->createMock(UserInterface::class);
//     $userServiceMock->method('getUserByEmail')->willReturn($userMock);

//     // Mock Session
//     Session::shouldReceive('put')->once()->with('user_id', $userMock->id);
    
//     // Create an instance of UserAuthService with mocked dependencies
//     $userAuthService = new UserAuthService($userServiceMock);

//     // Create request with login credentials
//     $request = new Request([
//         'email' => 'test@example.com',
//         'password' => 'password'
//     ]);

//     // Call login method
//     $isLoggedIn = $userAuthService->login($request);

//     // Assert that user is logged in
//     $this->assertTrue($isLoggedIn);
// }
}


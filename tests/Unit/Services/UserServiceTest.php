<?php

namespace Tests\Unit;

use App\Contracts\UserInterface;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
  use RefreshDatabase;
//chacks if user is returned successfully
  public function testIfUserIsCreatedSuccessfully()
  {
    $creationData = [
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'test@user.com',
      'role' => 'user',
      'password' => 'password'

    ];
    $this->assertTrue(class_exists(UserService::class));
    $mockInterface = Mockery::mock(UserInterface::class);
    $mockInterface->shouldReceive('createUser')->with($creationData)->andReturn(true);
    $userService = new UserService($mockInterface);
    $creationStatus = $userService->createUser($creationData);
    $this->assertEquals(1, $creationStatus);
  }
//tests if all the created users are retrieved
  public function testIfAllUsersAreRetrievedSuccessfully()
  {
    $users = User::factory()->count(3)->make();
    $mockInterface = Mockery::mock(UserInterface::class);
    $mockInterface->shouldReceive('getAllUsers')->andReturn($users);

    $userService = new UserService($mockInterface);
    $userList = $userService->getAllUsers();

    $this->assertInstanceOf(Collection::class, $userList);
    $this->assertCount(3, $userList);
  }
//checks if a user is retrieved by email or not
  public function testIfAUserCanBeRetrievedByEmail(){

    $user = User::factory()->make();
    $email = $user->email; 
    
    $mockInterface = Mockery::mock(UserInterface::class);
    $mockInterface->shouldReceive('getUserByEmail')
                      ->with($email)
                      ->andReturn($user);

    $userService = new UserService($mockInterface);

    $retrievedUser = $userService->getUserByEmail($email);
    $this->assertInstanceOf(User::class, $retrievedUser);
    $this->assertEquals($user->id, $retrievedUser->id);
    $this->assertEquals($user->email, $retrievedUser->email);
  }

  //checks if a user can be updated 
  public function testIfAUserDataCanBeUpdated(){
    for($i=0 ;$i<5; $i++)
    $user[] = User::factory()->make(['id'=>$i]);


    $id = $user[2]->id;
    $newEmail = "testing@gmail.com";
    $updateData = [
      'email'=> $newEmail
    ];
    $mockInterface = Mockery::mock(UserInterface::class);
    $mockInterface->shouldReceive('updateUser')
                      ->with($id, $updateData)
                      ->andReturn(User::factory()->make(['id' => 0, 'email' => $newEmail]));

    $userService = new UserService($mockInterface);

    $updatedUser = $userService->updateUser($id, $updateData);
    $this->assertInstanceOf(User::class, $updatedUser);
    $this->assertEquals($user[0]->id, $updatedUser->id);
    $this->assertEquals($newEmail, $updatedUser->email);
  }



}

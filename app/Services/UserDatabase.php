<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class UserDatabase implements UserInterface
{
    //create new data in users table
    public function createUser($creationData): bool
    {
        //create the new user in the user table and return 1 if creation is successful or 0 if it failed
        try {
            $newUser = User::create($creationData);
            $creationStatus = $newUser ? true : false;
        } catch (QueryException $e) {
            throw new Exception("The user creation process failed: " . $e->getMessage());
        }
        return $creationStatus;
    }
    //returns all the data from the users table
    public function getAllUsers(): Collection
    {
        try {
            $userList = User::all();
        } catch (QueryException $e) {
            throw new Exception("User list couldn't be retrieved" . $e->getMessage());
            $userList = null;
        }
        return $userList;
    }

    //returns a specific data by the email
    public function getUserByEmail($email): User
    {
        try {
            $user = User::find($email);
        } catch (QueryException $e) {
            throw new Exception("The user with that email doesn't exist.");
        }
        return $user;
    }
    //edit functionality for a user
    public function updateUser(int $id, $updateData): User
    {
        $user = User::find($id);
        if (!$user) {
            throw new ModelNotFoundException("User with ID $id not found.");
        }
        $user->fill($updateData);
        $user->save();

        return $user;
    }
}

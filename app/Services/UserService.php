<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\UserInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;


class UserService implements UserInterface
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    //Logic for userCreation
    public function createUser($creationData): bool
    {
        if (is_array($creationData) && !empty($creationData)) {
            //check if role is valid
            if (!in_array($creationData['role'], ['admin', 'user'])) {
                throw new \InvalidArgumentException('Invalid role specified.');
            }
            if ($creationData['email'] === '' || $creationData['email'] === null || $creationData['password'] === '' || $creationData['password'] === null || $creationData['role'] === '' || $creationData['role'] === null || $creationData['first_name'] === '' || $creationData['first_name'] === null || $creationData['last_name'] === '' || $creationData['last_name'] === null) {
                throw new Exception("Some empty data received while user creation.");
            }
            //Trim all the received data
            $creationData['email'] = trim($creationData['email']);
            $creationData['password'] = trim($creationData['password']);
            $creationData['role'] = trim($creationData['role']);
            $creationData['first_name'] = trim($creationData['first_name']);
            $creationData['last_name'] = trim($creationData['last_name']);
            //Create the user
            try {
                $newUser = $this->userInterface->createUser($creationData);
                $creationStatus = $newUser ? 1 : 0;
            } catch (Exception $e) {
                throw new Exception('Failed the user creation ' . $e->getMessage());
            }
            return $creationStatus;
        } else {
            throw new Exception("The data was not received by the server for user creation.");
        }
    }
    //logic for returning a user by id
    public function getUserByEmail($email): User
    {

        if ($email != '') {
            //Get the user
            try {
                $user = $this->userInterface->getUserByEmail($email);
            } catch (Exception $e) {
                throw new Exception('Failed the user creation ' . $e->getMessage());
            }
            return $user;
        } else {
            throw new Exception("The data was not received by the server for retrieving user by email operation.");
        }
    }

    //updates user data accordingly
    public function updateUser(int $id, $updateData): User
    {
        //logic for editing specific user details
        if ($id != 0 && is_array($updateData) && count($updateData) > 0) {

            $updatedUser = $this->userInterface->updateUser($id, $updateData);
        } else {
            throw new Exception("Data not received by the server for user update operation.");
        }
        return $updatedUser;
    }

    //gets all users
    public function getAllUsers(): Collection
    {

        try {
            $userList = $this->userInterface->getAllUsers();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve user list.");
        }
        return $userList;
    }
}

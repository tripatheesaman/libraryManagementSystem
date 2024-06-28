<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    public function createUser($creationData): bool;
    public function getAllUsers(): Collection;
    public function getUserByEmail($email): User;
    public function updateUser(int $id, $updateData): User;
}

<?php

namespace App\Services;

use App\Contracts\UserAuthInterface;
use App\Contracts\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AdminAuthService implements UserAuthInterface
{

    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    public function register(Request $request): bool
    {
        $registrationData = $request->all();
        try {
            $registrationData['role'] = 'admin';
            $isCreated = $this->userInterface->createUser($registrationData);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Failed to register user: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to register user: ' . $e->getMessage());
        }
        return $isCreated;
    }

    public function login(Request $request): bool
    {
        try {
            $user = $this->userInterface->getUserByEmail($request->email);
            if (!$user || !Hash::check($request->password, $user->password) || !($user->role == 'admin')) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            Session::put('user_id', $user->id);
            $isLoggedIn = true;
        } catch (\Exception $e) {
            throw new Exception("Failed to login");
        }
        return $isLoggedIn;
    }
    public function logout(): bool
    {
        try {
            Session::forget('user_id');
            Session::flush(); 
            return true; 
        } catch (\Exception $e) {
            report($e); 
            return false;
        }

    }
}

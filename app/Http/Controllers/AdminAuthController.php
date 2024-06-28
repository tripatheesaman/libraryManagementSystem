<?php

namespace App\Http\Controllers;

use App\Contracts\UserAuthInterface;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    protected $userAuthInterface;

    public function __construct(UserAuthInterface $userAuthInterface)
    {
        $this->userAuthInterface = $userAuthInterface;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:20',
                'first_name' => 'required|min:2|alpha',
                'last_name' => 'required|min:2|alpha',
            ]);
            $isRegistered = $this->userAuthInterface->register($request);
            if ($isRegistered) {
                return response()->json(['message' => 'Admin registered successfully'], 201);
            } else {
                return response()->json(['message' => 'Failed to register admin'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to register admin: ' . $e->getMessage()], 401);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8|max:20',
            ]);

            $isVerified = $this->userAuthInterface->login($request);
            if (!$isVerified) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
                  return redirect(url('/adminDashboard'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            if ($request->has('_token')) {   
                $this->userAuthInterface->logout();
            } else {
                throw new Exception('Unauthorized access');
            }
            return redirect('login');
        } catch (\Exception $e) {
            throw new Exception("Something went wrong");
        }
    }
}

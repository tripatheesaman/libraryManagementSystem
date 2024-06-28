<?php

namespace App\Contracts;
use Illuminate\Http\Request;


interface UserAuthInterface{
    public function register(Request $request):bool;
    public function login(Request $request):bool;
    public function logout():bool;
}

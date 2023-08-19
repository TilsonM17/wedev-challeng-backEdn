<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginUser
{
    use AsAction;

    public function handle(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return [
            'token' => Auth::user()->createToken('authToken')->plainTextToken,
        ];
    }
}

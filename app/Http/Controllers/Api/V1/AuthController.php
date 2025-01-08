<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        /**
         * @var User $user
         */
        $user = User::type(UserTypeEnum::USER)
            ->where('email', $data['username'])
            ->orWhere('mobile', $data['username'])
            ->first();

        if (!Hash::check($data['password'], $user?->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ]);
        }

        $token = $user->createToken(
            name: 'api-token-' . $request->userAgent(),
            expiresAt: now()->addMonth()
        );

        $hashedToken = $token->plainTextToken;

        return response()->json([
            'token' => $hashedToken,
            'type' => 'Bearer'
        ], 200);
    }

    function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                new Rules\RequiredIf(!$request->has('mobile')),
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],
            'mobile' => [new Rules\RequiredIf(!$request->has('email')), 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'type' => UserTypeEnum::USER,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return response()->json([
            'status' => true,
            'message' => 'User registration successful!'
        ], 200);
    }
}

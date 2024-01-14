<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // $user = User::all();
        // return [[$user]];

        $validator = $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $password = Hash::make($request->password);
        $validator['password'] = $password;

        $user = User::create($validator);
        $token = $user->createToken($user->email)->plainTextToken;

        if ($user) {
            return $this->successAuthResponse($user, $token, 'Complete Register');
        } else {
            return $this->errorResponse('Error Register');
        }
    }

    public function login(Request $request)
    {

        $validator = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validator['email'])->first();
        if (!$user || !Hash::check($validator['password'], $user->password)) {
            return $this->errorResponse('Credential Error');
        } else {
            $token = $user->createToken($user->email)->plainTextToken;
            return $this->successAuthResponse($user, $token, 'Login Complete');
        }
    }

    public function logout(Request $request, User $user)
    {
        // Retrieve the authenticated user
        // $user = Auth::user();

        // Revoke the token used for the current request's authentication
        // $user->currentAccessToken()->delete();
        if ($user) {
            $request->user()->currentAccessToken()->delete();
            Auth::logout();
            return $this->successResponse($user, 'Logout Complete');;
        } else {
            return $this->errorResponse("Log Out Fail!");
        }
    }

    public function index(User $user)
    {
        $user =  User::all();
        return $this->successResponse($user, 'All User List');
    }

    public function user(User $user)
    {
        $user =  User::where('role', 1)->get();
        return $this->successResponse($user, 'User List');
    }

    public function admin(User $user)
    {
        $user =  User::where('role', 0)->get();
        return $this->successResponse($user, 'Admin List');
    }
}

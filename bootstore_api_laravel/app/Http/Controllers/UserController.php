<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all(['name', 'email']);
        return response()->json($user);
    }


    public function getUser(Request $request)
    {
        try {
            $user = UserPoint::with('user')->find($request->id);;
            // $user = UserPoint::find($request->id);
            return response()->json($user);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function getUserOrder(Request $request)
    {
        try {
            $user = Order::with('user')->find($request->id);;
            // $user = UserPoint::find($request->id);
            return response()->json($user);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // return dd($request->all());
            $data = $request->all();
            // Registration
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->userPoints()->create([
                'points' => 100
            ]);
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $customClaims = ['exp' => null];
            
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                $token = JWTAuth::fromUser($user);

                return response()->json(['message' => 'User logged in successfully', 'user' => $user, 'token' => $token])->cookie('token', $token, 60);
            } else {
                return response()->json(['message' => 'Invalid login credentials'], 422);
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}

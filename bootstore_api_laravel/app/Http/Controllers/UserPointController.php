<?php

namespace App\Http\Controllers;

use App\Models\UserPoint;
use App\Http\Requests\StoreUserPointRequest;
use App\Http\Requests\UpdateUserPointRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserPointRequest $request)
    {
        $user = Auth::user();
        $userPoint = $user->userPoint->create($request->validated());
        return response()->json($userPoint, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPoint $userPoint)
    {
        $user = Auth::user();
        if ($user->id !== $userPoint->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json($userPoint);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPoint $userPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPointRequest $request, UserPoint $userPoint)
    {
        $user = Auth::user();
        if ($user->id !== $userPoint->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $userPoint->update($request->validated());
        return response()->json($userPoint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPoint $userPoint)
    {
        $user = Auth::user();
        if ($user->id !== $userPoint->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $userPoint->delete();
        return response()->json(null, 204);
    }
}

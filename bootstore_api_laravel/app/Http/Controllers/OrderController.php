<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::all();
            if ($orders->isEmpty()) {
                return response()->json([]);
            } else {
                return response()->json($orders);
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // Check if the user is authorized to create orders
        // Check if the token exists in the request headers
        $token = $request->header('Authorization');
        $jwtToken = str_replace('Bearer ', '', $token);
        try {
            // Decode the JWT token
            // Parse and verify the JWT token
            $parsedToken = JWTAuth::parseToken($jwtToken);

            // Access the authorization information from the token's payload
            $payload = $parsedToken->getPayload();
            $userId = $payload->get('sub'); // Assuming 'sub' contains the user ID

            if ($jwtToken) {
                // return dd($userId, $token);
                // $request->validate([
                //     'user_id' => 'required|integer',
                //     'total_price' => 'required|integer',
                //     'book_id' => 'required|json',
                // ]);
                $user = UserPoint::find($userId);
                if ($request->total_price <= $user->points) {
                    $order = Order::create([
                        'user_id' => $userId,
                        'total_price' => $request->total_price,
                        'books' => json_encode($request->books),
                    ]);
                    $user->update(['points' => $user->points - $request->total_price]);
                    return response()->json(['message' => 'Book order successfully', 'order' => $order], 201);
                } else {
                    return response()->json(['message' => 'Not enough points'], 422);
                }
            }
        } catch (JWTException $ex) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    /**
     * Get orders by user ID.
     */
    public function getOrdersByUserId($user_id)
    {
        // return dd($user_id);
        try {
            $orders = Order::where('user_id', $user_id)->get();
            if ($orders->isEmpty()) {
                return response()->json([]);
            } else {
                return response()->json($orders);
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $order)
    {
        try {
            // return dd($order->all());
            return response()->json($order->all());
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        try {
            return response()->json($order);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        // Retrieve the order
        $order = Order::findOrFail($order);

        // Check if the user is authorized to update the order
        if (auth()->user()->can('update', $order)) {
            // Your code to update the order
            return response()->json(['message' => 'Order updated successfully']);
        }

        // If the user is not authorized, return a 403 Forbidden response
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // return dd($order->all());
        try {
            $record = Order::find($id);

            // return dd($id);

            if ($record) {
                // If the record is found, delete it
                $user = UserPoint::find($record->user_id);
                $user->update(['points' => $user->points + $record->total_price]);
                $record->delete();
                return response()->json(['message' => 'Order deleted successfully'], 200);
        
                // return response()->json(['message' => 'Data deleted successfully']);
            } else {
                // If the record is not found, return an appropriate response
                return response()->json(['message' => 'Record not found'], 404);
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}

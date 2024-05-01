<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/user",
 *     summary="Get all users",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::get('/user', [UserController::class, 'index']);

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     summary="Get user by ID",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::get('/user/{id}', [UserController::class, 'getUser']);

/**
 * @OA\Get(
 *     path="/user/order/{id}",
 *     summary="Get user's orders by ID",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::get('/user/order/{id}', [UserController::class, 'getUserOrder']);

/**
 * @OA\Post(
 *     path="/register",
 *     summary="User registration",
 *     tags={"Authentication"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful registration",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::post('/register', [UserController::class, 'store'])->name('register');

/**
 * @OA\Post(
 *     path="/login",
 *     summary="User login",
 *     tags={"Authentication"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::post('/login', [UserController::class, 'login'])->name('login');

// Grouped routes with middleware

Route::group([], function () {
    /**
     * @OA\Get(
     *     path="/order",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::get('/order', [OrderController::class, 'index']);

    /**
     * @OA\Get(
     *     path="/order/{id}",
     *     summary="Get order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::get('/order/{id}', [OrderController::class, 'show']);

    /**
     * @OA\Get(
     *     path="/order/user/{id}",
     *     summary="Get orders by user ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::get('/order/user/{id}', [OrderController::class, 'getOrdersByUserId']);

    /**
     * @OA\Post(
     *     path="/order",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::post('/order', [OrderController::class, 'store']);

    /**
     * @OA\Put(
     *     path="/order/{id}",
     *     summary="Update order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::put('/order/{id}', [OrderController::class, 'update']);

    /**
     * @OA\Delete(
     *     path="/order/{id}",
     *     summary="Delete order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
});

/**
 * @OA\Get(
 *     path="/books",
 *     summary="Get all books",
 *     tags={"Books"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::get('books', [BookController::class, 'index'])->middleware('guest');

/**
 * @OA\Post(
 *     path="/books",
 *     summary="Create a new book",
 *     tags={"Books"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::post('books', [BookController::class, 'store']);

/**
 * @OA\Get(
 *     path="/books/{id}",
 *     summary="Get book by ID",
 *     tags={"Books"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Book ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::get('books/{id}', [BookController::class, 'show']);

/**
 * @OA\Put(
 *     path="/books/{id}",
 *     summary="Update book by ID",
 *     tags={"Books"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Book ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */
Route::put('books/{id}', [BookController::class, "update"]);

/**
 * @OA\Delete(
 *     path="/books/{id}",
 *     summary="Delete book by ID",
 *     tags={"Books"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Book ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent()
 *     )
 * )
 */

// Route::delete('books/{id}', [BookController::class, 'delete
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/{id}', [UserController::class, 'getUser']);
// Route::get('/user/order/{id}', [UserController::class, 'getUserOrder']);
// Route::post('/register', [UserController::class, 'store'])->name('register');
// Route::post('/login', [UserController::class, 'login'])->name('login');

// Route::group([], function () {
//     Route::get('/order', [OrderController::class, 'index']);
//     Route::get('/order/{id}', [OrderController::class, 'show']);
//     Route::get('/order/user/{id}', [OrderController::class, 'getOrdersByUserId']);
//     Route::post('/order', [OrderController::class, 'store']);
//     Route::put('/order/{id}', [OrderController::class, 'update']);
//     Route::delete('/order/{id}', [OrderController::class, 'destroy']);
// });

// Route::get('books', [BookController::class, 'index'])->middleware('guest');
// Route::post('books', [BookController::class, 'store']);
// Route::get('books/{id}', [BookController::class, 'show']);
// Route::put('books/{id}', [BookController::class, "update"]);
// Route::delete('books/{id}', [BookController::class, 'delete']);

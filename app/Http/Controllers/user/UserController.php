<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination (must be greater than 0)",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of records per page (must be greater than 0)",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=10
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search query for filtering results by user name, email, or division name",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="wahyu"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="all user"),
     *             @OA\Property(property="page", type="integer", example=1),
     *             @OA\Property(property="limit", type="integer", example=10),
     *             @OA\Property(property="total_rows", type="integer", example=100),
     *             @OA\Property(property="total_page", type="integer", example=10),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=20),
     *                     @OA\Property(property="division_id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="wahyu"),
     *                     @OA\Property(property="email", type="string", example="wahyu@gmail.com"),
     *                     @OA\Property(property="password", type="string", example="$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example=null),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example=null),
     *                     @OA\Property(property="key", type="integer", example=20),
     *                     @OA\Property(property="division_name", type="string", example="UI/UX DESIGNER")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid page or limit number",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="page must be greater than 0")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="limit must be greater than 0")
     *                 )
     *             }
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $page = $request->query('page');
        if($page < 1){
            return response()->json(['message' => 'page must be greater than 0'], 400);
        }

        $limit = $request->query('limit');
        if($limit < 1){
            return response()->json(['message' => 'limit must be greater than 0'], 400);
        }

        $search = $request->query('search') ? $request->query('search') : '';

        $search_db = $search ? "WHERE u.name LIKE '%".$search."%' OR u.email LIKE '%".$search."%' OR d.name LIKE '%".$search."%'" : "";
        
        $offset = ($page - 1) * $limit;

        $total = DB::select("SELECT count(*) as total from users as u join divisions as d on u.division_id = d.id ".$search_db."");

        $total_page = ceil($total[0]->total / $limit);

        $data = DB::select("SELECT u.*, u.id as 'key', d.name as division_name FROM users as u join divisions as d on u.division_id = d.id ".$search_db." order by u.id desc limit ".$offset.",".$limit."");

        return response()->json([
            'message' => 'all user',
            'page' => $page,
            'limit' => $limit,
            'total_rows' => $total[0]->total,
            'total_page' => $total_page,
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     summary="Get user details",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="detail user"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doeexample.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $data = User::find($id);
        if (!$data) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'detail user', 'data' => $data], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "division_id", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doeexample.com"),
     *             @OA\Property(property="division_id", type="integer", example=3),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Register"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doeexample.com"),
     *                 @OA\Property(property="division_id", type="integer", example=3),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="Name is required")
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="Email is invalid")
     *                 ),
     *                 @OA\Property(
     *                     property="division_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="Division is required")
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="array",
     *                     @OA\Items(type="string", example="Password min 6 characters")
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="array",
     *                     @OA\Items(type="string", example="Password confirmation not match")
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'division_id' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is registered',
            'division_id.required' => 'Division is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password min 6 characters',
            'password_confirmation.required' => 'Password confirmation is required',
            'password_confirmation.same' => 'Password confirmation not match'
        ]);

        $data = User::create([
            'name' => ucwords($request->input('name')),
            'email' => $request->input('email'),
            'division_id' => $request->input('division_id'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['message' => 'Register', 'data' => $data], 200);
    }

    /**
     * @OA\Patch(
     *     path="/api/user/{id}",
     *     summary="Update an existing user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "division_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doeexample.com"),
     *             @OA\Property(property="division_id", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="user update successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doeexample.com"),
     *                 @OA\Property(property="division_id", type="integer", example=3),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="Name is required")
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="Email is registered")
     *                 ),
     *                 @OA\Property(
     *                     property="division_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="Division is required")
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'division_id' => 'required',
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is registered',
            'division_id.required' => 'Division is required',
        ]);

        $data = $user->update([
            'name' => ucwords($request->input('name')),
            'email' => $request->input('email'),
            'division_id' => $request->input('division_id'),
        ]);

        return response()->json(['message' => 'user update successfully', 'data' => $data], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="user delete successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doeexample.com"),
     *                 @OA\Property(property="division_id", type="integer", example=3),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="user not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if(!$data){
            return response()->json(['message' => 'user not found'], 404);
        }
        
        $data->delete();
        return response()->json(['message' => 'user delete successfully', 'data' => $data], 200);
    }
}

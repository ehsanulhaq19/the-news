<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Auth"},
     *      summary="register",
     *      description="Register new user",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "first_name", "last_name", "password"},
     *            @OA\Property(property="email", type="string", format="string", example="User's email"),
     *            @OA\Property(property="first_name", type="string", format="string", example="User's first name"),
     *            @OA\Property(property="last_name", type="string", format="string", example="User's last name"),
     *            @OA\Property(property="password", type="string", format="string", example="User's password"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=201, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="201"),
     *             @OA\Property(
     *                  property="user",
     *                  type="object", 
     *                  @OA\Property(property="email",type="string"),
     *                  @OA\Property(property="first_name",type="string"),
     *                  @OA\Property(property="last_name",type="string")
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400, description="Bad request error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="400"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       ),
     *      @OA\Response(
     *          response=500, description="Internal server error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="500"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       )
     *  )
     */

    public function register(AuthRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
 
            $statusCode = SymfonyResponse::HTTP_CREATED;
            return response()->json([
                'status' => $statusCode, 
                'user' => $user
            ], $statusCode);

        } catch (Exception $e) {
            $statusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json([
                'status' => $statusCode, 
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="login",
     *      description="Login user",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="string", format="string", example="User's email"),
     *            @OA\Property(property="password", type="string", format="string", example="User's password"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="token", type="string", example="<secret_auth_token>"),
     *             @OA\Property(
     *                  property="user",
     *                  type="object", 
     *                  @OA\Property(property="email",type="string"),
     *                  @OA\Property(property="first_name",type="string"),
     *                  @OA\Property(property="last_name",type="string")
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400, description="Bad request error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="400"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401, description="Unauthorized error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="401"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       ),
     *      @OA\Response(
     *          response=500, description="Internal server error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="500"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       )
     *  )
     */

    public function login(AuthRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                $statusCode = SymfonyResponse::HTTP_UNAUTHORIZED;
                return response()->json([
                    'status' => $statusCode, 
                    'message' => "The provided credentials are incorrect"
                ], $statusCode);
            }
            
            $token = $user->createToken("userAuthToken")->plainTextToken;
            $statusCode = SymfonyResponse::HTTP_OK;
            return response()->json([
                'status' => $statusCode, 
                'token' => $token,
                'user' => $user
            ], $statusCode);
            
        } catch (Exception $e) {
            $statusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json([
                'status' => $statusCode, 
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}
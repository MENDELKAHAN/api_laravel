<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use App\Services\Api;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authentication process of the application.
    |
     */
    /**
     * constructor
     * Create a new AuthController instance.
     * @params: none
     * @return none
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * login
     * Get a JWT via given credentials.
     * @params: none
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {

            return $this->authenticatedUserData();

        } else {
            return response()->json(['error' => 'Invalid email or password.'], 401);
        }
    }

    public function authenticatedUserData()
    {
        $tokenData = array();
        $tokenData['name'] = auth()->user()['name'];
        $tokenData['email'] = auth()->user()['email'];
        $user = auth()->user();
        $role = "";
        if ($user->hasRole('super')) {
            $role = "super";
        } elseif ($user->hasRole('admin')) {
            $role = "admin";
        }

        $tokenData['role'] = $role;

        if( $role != 'super'){
            $role = Role::where('slug', $role)->first();
            
            $permissions = $role->permissions()->get();

            $userPermissions = array();
            foreach ($permissions as $permission) {
                $userPermissions[] = $permission['slug'];
            }

            $tokenData['permissions'] = $userPermissions;
        }
        $tokenData['timestamp'] = time();

        $apiObject = new Api();

        $jwt = $apiObject->generateJWT($tokenData);

        $ref = User::find(auth()->user()['id']);

        $ref->api_token = $jwt;

        $ref->save();

        return $jwt;
    }

    /**
     * me
     * Get the authenticated User
     * @params: none
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    /**
     * logout
     * Log the user out (Invalidate the token).
     * @params: none
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * refresh
     * Refresh a token.
     * @params: none
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->authenticatedUserData(); //$this->respondWithToken(auth()->refresh());
    }
    /**
     * respondWithToken
     * Get the token array structure.
     * @params: string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JWTAuthController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'cpf' => 'required|unique:users|max:11',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|string|min:6',
            'instituicao_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->cpf = $request->cpf;
        $user->email = $request->email;
        $user->instituicao_id = $request->instituicao_id;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpf' => 'required',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        return $this->authenticate($data);
    }

    /**
     * Auth for the Swagger
     *
     * @return JsonResponse
     */
    public function auth(Request $request)
    {
        $rawHeader = explode(' ', $request->header('Authorization'));
        if (count($rawHeader) !== 2) {
            return response()->json([
                'errors' => [
                    'authorization' => ['Invalid authorization header.']
                ]
            ], 422);
        }
        $authData = explode(':', base64_decode($rawHeader[1]));
        $data = [
            'cpf' => $authData[0],
            'password' => $authData[1]
        ];

        return $this->authenticate($data);
    }

    private function authenticate($data)
    {
        if (!$token = auth('api')->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }
}

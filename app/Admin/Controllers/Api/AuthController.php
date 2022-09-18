<?php
namespace App\Admin\Controllers\Api;

use App\Common\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests;

class AuthController extends ApiController
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Requests\LoginRequest $request
     * @return JsonResponse
     */
    public function login(Requests\LoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->response()->withError(401, '用户名或密码错误');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response()->withSuccess([
            'user' => ['name' => auth()->user()->name],
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

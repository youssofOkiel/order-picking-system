<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginUser extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
      $access_token = $this->authService->login($request->validated('email'), $request->validated('password'));

      return $this->successResponse([
          'access_token' => $access_token
      ]);
    }
}

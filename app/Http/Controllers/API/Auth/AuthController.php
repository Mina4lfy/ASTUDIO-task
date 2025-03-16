<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

# requests.
use App\Http\Requests\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

# models.
use App\Models\User;

# resources.
use App\Http\Resources\UserResource;

# facades.
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  /**
   * Register a new user.
   *
   * @param \App\Http\Requests\Request $request
   * @return UserResource
   */
  public function register(RegisterRequest $request)
  {
    # Create the user.
    User::create(array_merge($request->only(['first_name', 'last_name', 'email']), [
      'password' => bcrypt($request->password),
    ]));

    # Return access and refresh tokens.
    return $this->login(LoginRequest::createFrom($request));
  }

  /**
   * Log user in by email and password.
   *
   * @param \App\Http\Requests\Auth\LoginRequest $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function login(LoginRequest $request)
  {
    $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
      'grant_type'    => 'password',
      'client_id'     => config('passport.personal_access_client.id'),
      'client_secret' => config('passport.personal_access_client.secret'),
      'username'      => $request->email,
      'password'      => $request->password,
      'scope'         => '',
    ]);

    # Return error, if any.
    if ($response->json('error')) {
      return response()->json($response->json(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    return $response->json();
  }

  /**
   * Logout the currently logged-in user
   *
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function logout(Request $request)
  {
    # Revoke the current user's access token.
    $token = $request->user()->token();
    $token->revoked = true;
    $token->save();

    # Revoke the associated refresh token. (optional but recommended)
    $refreshTokenRepository = app(\Laravel\Passport\RefreshTokenRepository::class);
    $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

    return response()->json(['message' => 'Successfully logged out']);
  }
}
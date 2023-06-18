<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Google_Client;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function googleLogin(LoginRequest $request)
    {
        //Verify the ID token with GoogleAPI
        $idToken = $request->input('idToken');
        $client = new Google_Client(['client_id' => env('971766812836-re275ffnj3jnf9gcefunt2tavn29on7q.apps.googleusercontent.com')]);
        $payload = $client->verifyIdToken($idToken);
        // Log::info("message");($idToken);

        if ($payload) {
            // IdToken is valid, extract user information
            $email = $payload['email'];

            // Perform authentication or any other necessary actions
            $user = User::where('email', $email)->first();

            if ($user) {
                $role_id = $user->role_id;
                $username = $user->username;
                $info_id = $user->getAccordingIdFromRole();
                /** @var User $user */
                $token = $user->createToken('main')->plainTextToken;
                // Return a success response
                return response()->json([
                    'message' => 'Successful',
                    'email' => $email,
                    'username' => $username,
                    'role' => $user->getRoleName(),
                    'info_id' => $info_id,
                    'token' => $token
                ],
                    200);
            } else {
                return response(['message' => "This google account do not have permission to enter the site"], 403);
            }
        } else {
            return response()->json(['message' => 'Invalid token'], 400);
        }
    }
    public function logout(Request $request)
    {
        // $user = $request->user();
        // /** @var User $user */
        // $user->currentAccessToken()->delete();
        // return response()->json([''], 204);
    }
}

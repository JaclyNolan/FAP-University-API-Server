<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Google_Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * googleLogin is a function that verify the idToken that client send
     * return user data and token is successful
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function googleLogin(Request $request)
    {
        // Verify the ID token with GoogleAPI
        $idToken = $request->input('idToken');
        $client = new Google_Client(['client_id' => env('971766812836-re275ffnj3jnf9gcefunt2tavn29on7q.apps.googleusercontent.com')]);
        $payload = $client->verifyIdToken($idToken);

        // If idToken is invalid
        if (!$payload)
            return response()->json(['message' => 'Invalid token'], 400);

        // IdToken is valid, extract user information
        $email = $payload['email'];

        $user = User::where('email', $email)->first();

        // If email doesn't exist in the database
        if (!$user)
            return response()->json(['message' => "This google account do not have permission to enter the site"], 403);

        $user->username = $payload['name'];
        $info = $user->getInfoAccordingToRole();

        $picture = $info ? $info->picture : $payload['picture'];
        $user->email_avatar = $picture;

        // Email exist in the database return userdata
        /** @var User $user */
        $token = $user->createToken('main')->plainTextToken;

        // Return a success response
        return response()->json(
            [
                'message' => 'Successful',
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->getRoleName(),
                    'picture' => $picture,
                ],
                'token' => $token
            ],
            200
        );
    }

    /**
     * checkToken is a function that checks the avaliablity of the jwt (expired or not)
     * return user data if not expired
     * return an error if expired or not exist
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function checkToken(Request $request)
    {
        //Get PersonalAccessToken model
        /** @var User $user */
        $user = $request->user();
        $info = $user->getInfoAccordingToRole();

        $picture = $info ? $info->picture : $user->email_avatar;

        // The token is valid and not expired
        return response()->json([
            'message' => 'Token is valid',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->getRoleName(),
                'picture' => $picture,
            ]
        ], 200);
    }



    /**
     * logout is a function that soft delete the current access token
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $currentToken = $user->currentAccessToken();
        /** @var PersonalAccessToken $currentToken */
        $currentToken->delete();
        return response()->json('', 204);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    

    public function register(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User registered successfully.',
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request): JsonResponse {
        if(Auth::attempt(['email' => $request->email, 'password' => $request -> password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully',
            ];
    
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized.'
            ];
    
            $response['data'] =  ['error' => 'Unauthorized'];
            return response()->json($response, 400);
        }
    }

    public function logout(Request $request): JsonResponse {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            Log::error('Token revocation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to revoke tokens'], 500);
        }
    
        return response()->json(['message' => 'Tokens revoked successfully']);
    }
}

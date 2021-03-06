<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    /**
     * Authenticate an user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'password');

        $validator = Validator::make($credentials, [
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'code' => 1,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['code' => 2, 'message' => 'Invalid credentials.'], 401);
        }
    }

    /**
     * Get the user by token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function getUser(Request $request)
    public function getUser()
    {
//        JWTAuth::setToken($request->input('token'));
//        $user = JWTAuth::toUser();
//        return response()->json($user);
	    try {

		    if (! $user = JWTAuth::parseToken()->authenticate()) {
			    return response()->json(['user_not_found'], 404);
		    }

	    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

		    return response()->json(['token_expired'], $e->getStatusCode());

	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

		    return response()->json(['token_invalid'], $e->getStatusCode());

	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

		    return response()->json(['token_absent'], $e->getStatusCode());

	    }

	    $roles = $user->role();
	    $user->role = $roles->pluck('id');
	    $user->roleName = $roles->pluck('name');

	    // the token is valid and we have found the user via the sub claim
	    return response()->json(compact('user'));
    }

	public function createRole(Request $request){
		$role = new Role();
		$role->name = $request->input('name');
		$role->save();

		return response()->json("created");
	}

	public function createPermission(Request $request){
		$viewUsers = new Permission();
		$viewUsers->name = $request->input('name');
		$viewUsers->save();

		return response()->json("created");

	}

	public function assignRole(Request $request){
		$user = User::where('name', '=', $request->input('name'))->first();

		$role = Role::where('name', '=', $request->input('role'))->first();
		//$user->attachRole($request->input('role'));
		$user->roles()->attach($role->id);

		return response()->json("created");
	}

	public function attachPermission(Request $request){
		$role = Role::where('name', '=', $request->input('role'))->first();
		$permission = Permission::where('name', '=', $request->input('name'))->first();
		$role->attachPermission($permission);

		return response()->json("created");
	}
}

<?php

namespace App\Http\Controllers;

use Log;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Create a user.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'   => 'required|unique:users|max:255',
            'email'      => 'required|unique:users|email|max:255',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'address'    => 'required',
            'country'    => 'required',
            'language'   => 'required',
            'currency'   => 'required',
            'phone'      => 'required'
        ]);

        if ($validator->fails()) {
            $result = ['success' => false, 'errors' => $validator->errors()->all()];
            return response()->json($result, 422);
        }
        
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->get('password'));
        if(!$user->save()) {
            Log::error('Unable to save user');
            $result = ['success' => false, 'errors' => ['Unable to save user']];
            return response()->json($result, 500);
        }
        
        return response()->json(['success' => true], 201);
    }
    
    /**
     * Get a user.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function getUser(Request $request, User $user)
    {        
        return response()->json($user, 200);
    }
    
    
    /**
     * Update a user
     * 
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username'   => 'unique:users,username,'.$user->id.'|max:255',
            'email'      => 'unique:users,email,'.$user->id.'|email|max:255',
        ]);

        if ($validator->fails()) {
            $result = ['success' => false, 'errors' => $validator->errors()->all()];
            return response()->json($result, 422);
        }
        
        $user->fill($request->all());
        if(!$user->save()) {
            Log::error('Unable to update user');
            $result = ['success' => false, 'errors' => ['Unable to update user']];
            return response()->json($result, 500);
        }
        
        return response()->json(['success' => true], 200);
    }
    
    /**
     * Delete a user
     * 
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function deleteUser(Request $request, User $user)
    {
        if(!$user->delete()) {
            return response()->json(['success' => false, 'errors' => ['Unable to delete user']], 500);
        }
        
        return response()->json(['success' => true], 200);
    }
}

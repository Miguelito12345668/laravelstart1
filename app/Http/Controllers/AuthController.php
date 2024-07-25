<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Validator;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);

        if($valiator->fails()){
            return $this->sendError('Validation Error .', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['user'] = $user;

        return $this->sendResponse($success, 'User register successfuly.');
    }
    public function login(){
        $credetials = request(['email', 'password']);

        if(! $token = auth()->attempt($credetials)){
            return $this->sendError('Unathorized.', ['error' => 'Unathorized']);
        }

        $success = $this->respondWithToken($token);

        return $this->sendResponse($success, 'User login successfully.');
    }

    public function profile(){
        $success = auth()->user();

        return $this->sendResponse($success, "Profile fetch successfully.");
    }

    public function refresh(){
        $success = $this->respondWithToken(auth()->refresh());
        return $this->sendResponse($success, "Profile fetch successfully.");
    }

    public function logout(){
        $success = auth()->logout();
        return $this->sendResponse($success, "Successfully logged out.");
    }
   
    
    protected function respondWithToken($token){
        return[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>auth()->factory()->getTTL() * 60,
        ];
    }
}

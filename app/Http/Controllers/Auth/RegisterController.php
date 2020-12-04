<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Infrastructurs\Repositories\RegisterRepository;

class RegisterController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

    }

    protected function create(Request $request)
    {
        $input = $request->input();
        
        $rules = [
            "user_fullname" => "required",
            "user_email" => "required|email|unique:users,user_email",
            "user_password" => "required",
            "role" => "required|array"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $registerRepo = new RegisterRepository();

        $data = [
            "user_email" => $input["user_email"], 
            "user_password" => $input["user_password"], 
            "user_fullname" => $input["user_fullname"], 
            "register_activation_code" => get_uuid(), 
            "user_role" => $input["role"],
        ];

        $registerCreate = $registerRepo->create($data);
        
        if (!$registerCreate["status"]) {
            $response = ["message" => $registerCreate["message"]];
            return renderResponse($response, 400);
        }

        $response = $registerCreate;

        return renderResponse($response["collection"], 200);
    }

    protected function update(Request $request,$id)
    {
        $input = $request->input();
        
        $rules = [
            "user_fullname" => "required",
            "user_email" => "required|email|unique:users,user_email"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $registerRepo = new RegisterRepository();

        $response = $registerRepo->update($input,$id);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);
       
    }

    protected function delete(Request $request,$id)
    {
        $registerRepo = new RegisterRepository();

        $response = $registerRepo->delete($id);
        
        if (!$response["status"]) {
            $response = ["message" => $registerCreate["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response, 200);
       
    }

    protected function read(Request $request)
    {
        $registerRepo = new RegisterRepository();

        $input = $request->input();

        $response = $registerRepo->getData($input);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        $response = $response;

        return renderResponse($response["collection"], 200);

    }

    protected function find($id)
    {
        $registerRepo = new RegisterRepository();

        $response = $registerRepo->findById($id);

        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 404);
        }

        return renderResponse($response["collection"], 200);
       
    }

}

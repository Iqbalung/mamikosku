<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Infrastructurs\Repositories\RegisterRepository;
use App\Http\Infrastructurs\Repositories\UserRepository;
use App\Http\Infrastructurs\Repositories\CreditRepository;

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
            "user_email" => "required|email|unique:users,email",
            "user_password" => "required",
            "user_role" => "required"
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
            "user_password" => Hash::make($input["user_password"]), 
            "user_fullname" => $input["user_fullname"], 
            "register_activation_code" => get_uuid(), 
            "user_role" => $input["user_role"],
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

    protected function verification(Request $request,$id)
    {

        $input = $request->input();
        $input['activation_code'] = $id;

        $rules = [
            "user_email" => "required",
            "activation_code" => "required|unique:users,activation_code",
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute cannot used'
        ];


        $validator = Validator::make($input, $rules, $customMessages);
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $registerRepo = new RegisterRepository();
        $userRepo = new UserRepository();
        $creditRepo = new CreditRepository();

        $registration = $registerRepo->findById($id);

        if (!$registration["status"]) {
            $registration = ["message" => $registration["message"]];
            return renderResponse($registration, 404);
        }

        if($registration["status"]){
            $registration['collection']->makeVisible(['user_password']);
            $reg = $registration['collection']->getAttributes();
            $user = [
                'email' => $reg['user_email'],
                'password' => $reg['user_password'],
                'fullname'=> $reg['user_fullname'],
                'role'=> $reg['user_role'],
                'activation_code'=> $id,
            ];


            if($user['role']=="premium"){
                $user['credit'] = 40;
            }

            if($user['role']=="regular"){
                $user['credit'] = 20;
            }

            $user = $userRepo->create($user);

            if($user['status']){
                $user = $user['collection']->getAttributes();
                if(!empty($user['credit'])){
                    $credit = [
                        'amount' => $user['credit'],
                        'user_id' => $user['id'],
                        'description' => "Bonus Registration for ".$user['role'],
                    ];

                    $credit = $creditRepo->create($credit);
                }
            }
        }

        return renderResponse($registration["collection"], 200);
       
    }

}

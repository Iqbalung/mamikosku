<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Infrastructurs\Repositories\KostRepository;

class KostController extends Controller
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
            "name_kost" => "required|unique:kosts,name_kost",
            "location" => "required",
            "address" => "required",
            "category" => "required",
            "price" => "required|int"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $kostRepo = new KostRepository();

        $response = $kostRepo->create($input);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);
    }

    protected function update(Request $request,$id)
    {
        $input = $request->input();
        
        $rules = [
            "name_kost" => "required|unique:kosts,name_kost",
            "location" => "required",
            "address" => "required",
            "category" => "required"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $kostRepo = new KostRepository();

        $response = $kostRepo->update($input,$id);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);
       
    }

    protected function delete(Request $request,$id)
    {
        $kostRepo = new KostRepository();

        $response = $kostRepo->delete($id);
        
        if (!$response["status"]) {
            $response = ["message" => $registerCreate["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response, 200);
       
    }

    protected function read(Request $request)
    {
        $kostRepo = new KostRepository();

        $input = $request->input();

        $response = $kostRepo->getData($input);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);

    }

    protected function find($id)
    {
        $kostRepo = new KostRepository();

        $response = $kostRepo->findById($id);

        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 404);
        }

        return renderResponse($response["collection"], 200);
       
    }

}

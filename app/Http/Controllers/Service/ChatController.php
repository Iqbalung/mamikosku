<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Infrastructurs\Repositories\ChatRepository;

class ChatController extends Controller
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
            "text" => "required|max:255",
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $registerRepo = new ChatRepository();

        $registerCreate = $registerRepo->create($input);
        
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
            "text" => "required|max:255"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $registerRepo = new ChatRepository();

        $response = $registerRepo->update($input,$id);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);
       
    }

    protected function delete(Request $request,$id)
    {
        $registerRepo = new ChatRepository();

        $response = $registerRepo->delete($id);
        
        if (!$response["status"]) {
            $response = ["message" => $registerCreate["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response, 200);
       
    }

    protected function read(Request $request)
    {
        $registerRepo = new ChatRepository();

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
        $registerRepo = new ChatRepository();

        $response = $registerRepo->findById($id);

        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 404);
        }

        return renderResponse($response["collection"], 200);
       
    }

}

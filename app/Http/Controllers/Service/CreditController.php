<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Infrastructurs\Repositories\CreditRepository;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user;

    public function __construct(Request $request)
    {
         $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

    }

    protected function create(Request $request)
    {
        $input = $request->input();
        
        $rules = [
            "amount" => "required|int",
            "description" => "required",
            "type" => "required"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $creditRepo = new CreditRepository($this->user);

        $registerCreate = $creditRepo->create($input);
        
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
            "amount" => "required|int",
            "type" => "required"
        ];

        $validator = Validator::make($input, $rules, config("mamikos.message"));
        
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response["status"] = false;
            $response["message"] = $error;
            return renderResponse($response, 400);
        }

        $creditRepo = new CreditRepository($this->user);

        $response = $creditRepo->update($input,$id);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response["collection"], 200);
       
    }

    protected function delete(Request $request,$id)
    {
        $creditRepo = new CreditRepository($this->user);

        $response = $creditRepo->delete($id);
        
        if (!$response["status"]) {
            $response = ["message" => $registerCreate["message"]];
            return renderResponse($response, 400);
        }

        return renderResponse($response, 200);
       
    }

    protected function read(Request $request)
    {
        $creditRepo = new CreditRepository($this->user);

        $input = $request->input();

        $response = $creditRepo->getData($input);
        
        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 400);
        }

        $response = $response;

        return renderResponse($response["collection"], 200);

    }

    protected function find($id)
    {
        $creditRepo = new CreditRepository($this->user);

        $response = $creditRepo->findById($id);

        if (!$response["status"]) {
            $response = ["message" => $response["message"]];
            return renderResponse($response, 404);
        }

        return renderResponse($response["collection"], 200);
       
    }

}

<?php

namespace App\Http\Infrastructurs\Repositories;

use App\Http\Infrastructurs\Interfaces\RepositoryInterface;
use App\User;
use \Validator;
use Illuminate\Support\Arr;

class UserRepository implements RepositoryInterface
{
    public $primaryKey;
    public $orderBy;    

    public function __construct()
    {
        $register = new User();
        $this->primaryKey = $register->getKeyName();     
    }

    public function create($data)
    {
        try {

            $model = new User();
            $res = User::create($data);
            $response['status'] = true;
            $response['property'] = [
                                        'primary_key' => $this->primaryKey,
                                        $this->primaryKey => $res->primaryKey,
                                    ];
            $response['collection'] = $res;
            return $response;
        
        } catch (\Exception $e) {
            dd($e);
            $response["status"] = false;
            $response["property"] = "";
            $response["message"] = config("mamikos.message.create_failed");
            return $response;
        
        }
    }

    public function update($data,$id)
    {
       
        $model = new User();
        $find = User::where($this->primaryKey,"=",$id)->first();

        try {

            $fillableKeys = is_null($model->getFillable()) ? [] : $model->getFillable();

            foreach ($fillableKeys as $k => $v) {
                if (!empty($data[$v])) {
                    $find->$v = $data[$v];
                }
            }

            $save = $find->save();

            if (!$save) {
                $response['status'] = false;
                $response['property'] = '';
                $response['message'] = config('paket_mile.message.update_failed');

                return $response;
            }

            $response['status'] = true;
            $response['collection'] = $find->getAttributes();
        
        }catch (\Exception $e) {
            dd($e);
            $response["status"] = false;
            $response["property"] = "";
            $response["message"] = config("mamikos.message.update_failed");
            return $response;
        
        }

        return $response;
    }

    public function delete($id)
    {
        $response["status"] = false;

        $model = new User();
        $primaryKey = $model->getKeyName(); 

        try {
            
            $res = User::where($this->primaryKey, $id)->delete();
            
        } catch (\Exception $e) {
            
            if (!$res) {
                $response["status"] = false;
                $response["message"] = config("mamikos.message.delete_failed");
                return $response;
            }

        }
        

        $response["status"] = true;
        $response["message"] = config("mamikos.message.delete_success");

        return $response;
    }

    public function getData($query_string = array())
    {
        $limit = ifunsetempty($query_string,"limit",config("mamikos.default_limit"));
        $sortBy = ifunsetempty($query_string,"sort_by","created_at");        
        $sortOrder = ifunsetempty($query_string,"sort_order","desc");
        $id = ifunsetempty($query_string,"id",null);
        $search_keywords = ifunsetempty($query_string,"q",null);

        $search = ($search_keywords != null) ? [
            ifunsetempty($query_string,"fields","fullname") => $search_keywords,
            ifunsetempty($query_string,"fields","location_code") => $search_keywords,
            ifunsetempty($query_string,"fields","location_phone") => $search_keywords,
            ifunsetempty($query_string,"fields","location_address") => $search_keywords 
        ] : null ;
        
        $data = User::orderBy($sortBy,$sortOrder);
        
        foreach ($model->getFillable() as $key => $value) {
            if(!empty($query_string[$value])){
                $data->where($value, $query_string[$value]);
            }
        }

        if(!empty($id)){
            $data->whereIn("id", $id);
        }

        if(is_array($search) AND !empty($search)){
            $data->where(function($query) use ($search){
                $i = 0;
                foreach ($search as $key => $value) {
                    if ($i == 0 ){
                       $query->where($key,"like","%".$value."%");
                    }else{
                       $query->orWhere($key,"like","%".$value."%");
                    }
                   $i++;
               }
           });
        }

        $response["status"] = true;
        $response["property"] = null;
        $response["collection"] = $data->paginate($limit)->appends(\Illuminate\Support\Facades\Input::except("page"));

        return $response;
    }

    public function findAll($limit = null)
    {
        if (!$limit) {
            $data = User::limit($limit)->orderBy($this->orderBy[0],$this->orderBy[1])
            ->get()->toArray();
        } else {
            $data = User::orderBy($this->orderBy[0],$this->orderBy[1])->get()->toArray();
        }

        $response["status"] = true;
        $response["property"] = null;
        $response["collection"] = $result;

        return $response;
    }

    public function findById($id)
    {
        $res = User::where($this->primaryKey,"=",$id)->first();

        if (!$res) {
            $response['status'] = false;
            $response['property'] = '';
            $response['message'] = config('mamikos.message.data_not_found');

            return $response;
        }

        $response["status"] = true;
        $response["property"] = null;
        $response["collection"] = $res;

        return $response;
    }

    public function findByEmail($id)
    {
        $res = User::where("email","=",$id)->first();

        if (!$res) {
            $response['status'] = false;
            $response['property'] = '';
            $response['message'] = config('mamikos.message.data_not_found');

            return $response;
        }

        $response["status"] = true;
        $response["property"] = null;
        $response["collection"] = $res;

        return $response;
    }

}

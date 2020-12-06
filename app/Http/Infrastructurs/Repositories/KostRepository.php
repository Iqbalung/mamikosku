<?php

namespace App\Http\Infrastructurs\Repositories;

use App\Http\Infrastructurs\Interfaces\RepositoryInterface;
use App\Http\Models\Kost;
use \Validator;
use Illuminate\Support\Arr;

class KostRepository implements RepositoryInterface
{
    public $primaryKey;
    public $orderBy;    

    public function __construct()
    {
        $register = new Kost();
        $this->primaryKey = $register->getKeyName();     
    }

    public function create($data)
    {
        try {

            $model = new Kost();
            $res = Kost::create($data);
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
       
        $model = new Kost();
        $find = Kost::where($this->primaryKey,"=",$id)->first();

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

        $model = new Kost();
        $primaryKey = $model->getKeyName(); 

        try {
            
            $res = Kost::where($this->primaryKey, $id)->delete();
            
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
        $model = new Kost();

        $limit = ifunsetempty($query_string,"limit",config("mamikos.default_limit"));
        $sortBy = ifunsetempty($query_string,"sort_by","created_at");        
        $sortOrder = ifunsetempty($query_string,"sort_order","desc");
        $id = ifunsetempty($query_string,"kost_id",null);
        $search_keywords = ifunsetempty($query_string,"q",null);


        $search = ($search_keywords != null) ? [
            ifunsetempty($query_string,"fields","location") => $search_keywords,
            ifunsetempty($query_string,"fields","address") => $search_keywords,
            ifunsetempty($query_string,"fields","name_kost") => $search_keywords 
        ] : null ;
        
        $data = Kost::orderBy($sortBy,$sortOrder);
        
        foreach ($model->getFillable() as $key => $value) {
            if(!empty($query_string[$value])){
                $data->where($value, $query_string[$value]);
            }
        }

        if(!empty($id)){
            $data->whereIn("kost_id", $id);
        }

        if(!empty($query_string['owner_user_id'])){
            $data->where("owner_user_id", $query_string["owner_user_id"]);
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
            $data = Kost::limit($limit)->orderBy($this->orderBy[0],$this->orderBy[1])
            ->get()->toArray();
        } else {
            $data = Kost::orderBy($this->orderBy[0],$this->orderBy[1])->get()->toArray();
        }

        $response["status"] = true;
        $response["property"] = null;
        $response["collection"] = $result;

        return $response;
    }

    public function findById($id)
    {
        $res = Kost::where($this->primaryKey,"=",$id)->first();
        Kost::where($this->primaryKey,"=",$id)->update(["hits"=>$res['hits']+1]);

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

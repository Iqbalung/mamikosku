<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;

class Register extends Eloquent
{

	use SoftDeletes;

    protected $primaryKey = 'register_activation_code';
    protected $collection = 'registers';
    protected $fillable = [
    	'user_email',
        'user_password',
        'user_fullname',
        'register_activation_code',
        'user_role',

    ];
    protected $hidden = [ 'created_at' ,'updated_at','user_password','register_activation_code','deleted_at'];




}

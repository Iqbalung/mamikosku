<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kost extends Eloquent
{

	use SoftDeletes;

    protected $primaryKey = 'kost_id';
    protected $collection = 'kosts';
    protected $fillable = [
    	'name_kost',
        'location',
        'price',
        'lat',
        'lon',
        'owner_user_id',
        'status',
        'category',

    ];
    protected $hidden = [ 'created_at' ,'updated_at'];




}

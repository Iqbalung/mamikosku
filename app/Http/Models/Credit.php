<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Eloquent
{

	use SoftDeletes;

    protected $primaryKey = 'id';
    protected $collection = 'credits';
    protected $fillable = [
        'amount',
        'description',
        'created_at',
        'updated_at',
        'type',
        'id',
        'user_id'
    ];
    protected $hidden = ['status'];




}

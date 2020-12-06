<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Eloquent
{

	use SoftDeletes;

    protected $primaryKey = 'chat_id';
    protected $collection = 'chats';
    protected $fillable = [
    	'owner_user_id',
        'consumer_user_id',
        'kost_id',
        'text',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];




}

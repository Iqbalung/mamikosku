<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Token Name
    |--------------------------------------------------------------------------
    |
    | untuk kepentingan clinet token pada app
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */	

	'token_name' => env('TOKEN_NAME','testing'),

    /*
    |--------------------------------------------------------------------------
    | Header Auth
    |--------------------------------------------------------------------------
    |
    | parameter yang client kirim saat mengirim token oauth
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */  
    'header_auth' => env('HEADER_AUTH',"X-Auth-Key"),


    /*
    |--------------------------------------------------------------------------
    | Url Service
    |--------------------------------------------------------------------------
    |
    | url ke server service paket mile
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */  
    'url_service' => env('URL_SERVICE','https://servicedev.mile.app/api/webhook'),

	/*
    |--------------------------------------------------------------------------
    | Default Limit
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk default limit data saat paginasi
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */
	'default_limit' => env("DEFAULT_LIMIT",20),


	/*
    |--------------------------------------------------------------------------
    | Default all
    |--------------------------------------------------------------------------
    |
    | default_[*] digunakan saat user menambah organisasi baru, 
    | setiap user memiliki default role group location
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */
	'default_role' => env('DEFAULT_ROLE',"admin,worker,manager"),
	'default_group' => env('DEFAULT_GROUP',"default"),
	'default_group_color' => env('DEFAULT_GROUP_COLOR',"#02A8F3"),
	'default_location' => env('DEFAULT_LOCATION',"default"),
    'default_user_password' => env('DEFAULT_USER_PASSWORD',"password"),    
    


	/*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | digunakan untuk kasus saat beberapa kodnisi membutuhkan untuk beberapa role saja, 
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */
	'role_superadmin' => env('ROLE_SUPERADMIN','superadmin'),
	'role_admin' => env('ROLE_ADMIN','admin'),
	'role_worker' => env('ROLE_WORKER','worker'),


	/*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    |
    | digunakan untuk flag di database
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */
	'status_active' => env('STATUS_ACTIVE',1),
	'status_inactive' => env('STATUS_INACTIVE',0),
	'status_delete' => env('STATUS_DELETE',-1),

	/*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    |
    | digunakan membuat pesan response pada frontend
    | dibuatkan aliases agar tidak mengetik ulang pesan yang sama
    | membuat grouping agar tersusun rapi. 
    | bisa menggunakan ".env" file untuk mengubahnya.
    |
    */
	'message' => [
        'unverified' => env('UNVERIFIED',"Acount unverified"),        
		'data_verification_failed' => env('DATA_VERIFICATION_FAILED',"Verification failed"),
		'logout_failed' => env('LOGOUT_FAILED',"Logout failed"),
		'login_failed' => env('LOGIN_FAILED',"Login failed, please check your email or password."),
		'duplicate_email' => env('DUPLICATE_EMAIL',"Email already used"),
		'duplicate_name' => env('DUPLICATE_NAME',"Name already used"),
		'duplicate_role' => env('DUPLICATE_ROLE',"Role already used"),
		'duplicate_user' => env('DUPLICATE_USER',"User with same email address already used"),
		'duplicate_location' => env('DUPLICATE_LOCATION',"Location already used"),
		'duplicate_webhook' => env('DUPLICATE_WEBHOOK',"Webhook already used"),
		'org_not_found' => env('ORG_NOT_FOUND',"Organization not found"),
		'org_not_available' => env('ORG_NOT_AVAILABLE',"Name not available"),
		'route_not_found' => env('ROUTE_NOT_FOUND',"URL Address not found"),
		'role_not_found' => env('ROLE_NOT_FOUND',"Role not found"),
        'data_not_found' => env('DATA_NOT_FOUND',"Data not found"),
		'url_not_found' => env('DATA_NOT_FOUND',"URL not found"),
		'unauthorized' => env('UNAUTHORIZED',"You don't have access"),
		'unpermitted' => env('UNPERMITTED',"You don't have permission"),
		'duplicate_group' => env('DUPLICATE_GROUP',"Group name already exist"),
		'update_failed' => env('UPDATE_FAILED',"Update data failed, data not found"),
		'create_failed' => env('CREATE_FAILED',"Create data failed"),
		'delete_failed' => env('DELETE_FAILED',"Delete data failed, data not found"),
		'password_wrong' => env('PASSWORD_WRONG',"Wrong password"),
        'data_saved' => env('DATA_SAVED',"Success data saved!"),        
		'delete_success' => env('DELETE_SUCCESS',"Success deleted!"),
        'update_success' => env('DELETE_SUCCESS',"Success updated!"),
        'org_name.unique_insensitive'=>'Organization already exists',
        'user.full_name.required'=>'Please input full name',
        'user.email.required'=>'Please input email',
        'user.username.required'=>'Please input username',
        'user.password.required'=>'Please input password',
        'user.email.unique'=>'Email already exists',
        'user.username.unique'=>'Username already exists in this organization',
        'username_exist'=>'Username already exists in this organization',
        'org_name.required'=>'Please input organization',
        'outdated'=>'Update data failed, data outdated'
	],

	'is_available' => env('IS_AVAILABLE',"is_available"),
    
    'default_form_task' => ['text','date','datetime','time','dropdown','number','long_text']

];
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Models\Register;
use Log;

class RegisterTest extends TestCase
{
    use WithFaker;
    /**
     * Balance Register.
     *
     * @return void
     */
    
    /**
     * SCENARIO:
     *
     * 1. Register User / Regular / Permium / Owner
     * 2. Verification
     * 3. Login
     * 4. Check Credit
     *=
     *
     */



    public function test_register_user_owner(){
        $body = [
            "user_fullname"=> $this->faker->name,
            "user_email"=> $this->faker->email,
            "user_password"=> "password",
            "user_role"=> "owner"
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/user/register"), $body, $header);
        $GLOBALS['owner'] = json_decode($response->content(),true);
        $GLOBALS['cred_owner'] = $body; 
        $response->assertStatus(200);
    }

    public function test_register_user_premium(){
        $body = [
            "user_fullname"=> $this->faker->name,
            "user_email"=> $this->faker->email,
            "user_password"=> "password",
            "user_role"=> "premium"
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/user/register"), $body, $header);
        $GLOBALS['premium'] = json_decode($response->content(),true);
        $GLOBALS['cred_premium'] = $body; 
        $response->assertStatus(200);
    }

    public function test_register_user_regular(){
        $body = [
            "user_fullname"=> $this->faker->name,
            "user_email"=> $this->faker->email,
            "user_password"=> "password",
            "user_role"=> "regular"
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/user/register"), $body, $header);
        $GLOBALS['regular'] = json_decode($response->content(),true);
        $GLOBALS['cred_regular'] = $body; 
        $response->assertStatus(200);
    }

    public function test_verification_regular(){
        $user_db = Register::where('user_email',$GLOBALS['regular']['user_email'])->first();
        $user_db = $user_db->getAttributes();
        $body = [
            "user_email"=> $GLOBALS['regular']['user_email']
        ];
        $header['Accept'] = "application/json";
        $response = $this->put(url("/api/v1/user/verification/".$user_db['register_activation_code']), $body, $header);
        $GLOBALS['v_regular'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_verification_owner(){
        $user_db = Register::where('user_email',$GLOBALS['owner']['user_email'])->first();
        $user_db = $user_db->getAttributes();
        $body = [
            "user_email"=> $GLOBALS['owner']['user_email']
        ];
        $header['Accept'] = "application/json";
        $response = $this->put(url("/api/v1/user/verification/".$user_db['register_activation_code']), $body, $header);
        $GLOBALS['v_owner'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_verification_premium(){
        $user_db = Register::where('user_email',$GLOBALS['premium']['user_email'])->first();
        $user_db = $user_db->getAttributes();
        $body = [
            "user_email"=> $GLOBALS['premium']['user_email']
        ];
        $header['Accept'] = "application/json";
        $response = $this->put(url("/api/v1/user/verification/".$user_db['register_activation_code']), $body, $header);
        $GLOBALS['v_premium'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_login_regular(){
        $body = [
            "email"=> $GLOBALS['regular']['user_email'],
            "password"=> $GLOBALS['cred_regular']['user_password']
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/login"), $body, $header);
        $GLOBALS['l_regular'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_login_owner(){
        $body = [
            "email"=> $GLOBALS['owner']['user_email'],
            "password"=> $GLOBALS['cred_owner']['user_password']
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/login"), $body, $header);
        $GLOBALS['l_owner'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_login_premium(){
        $body = [
            "email"=> $GLOBALS['premium']['user_email'],
            "password"=> $GLOBALS['cred_premium']['user_password']
        ];
        $header['Accept'] = "application/json";
        $response = $this->post(url("/api/v1/login"), $body, $header);
        $GLOBALS['l_premium'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    
    public function test_credit_regular(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_regular']['token'];
        print_r($GLOBALS['l_regular']['token']);
        $response = $this->get(url("/api/v1/credit"), $header);
        $GLOBALS['credit_regular'] = json_decode($response->content(),true);
        print_r($GLOBALS['credit_regular']);
        if(!empty($GLOBALS['credit_regular']['data']));{
            $response->assertOK();
        }
    }

    public function test_credit_owner(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_owner']['token'];
        $response = $this->get(url("/api/v1/credit"), $header);
        $GLOBALS['credit_owner'] = json_decode($response->content(),true);
        if(!empty($GLOBALS['credit_owner']['data']));{
            $response->assertOK();
        }
    }

    public function test_credit_premium(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/credit"), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

}

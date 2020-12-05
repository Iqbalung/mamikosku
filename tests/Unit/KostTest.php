<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Models\Register;
use Log;

class KostTest extends TestCase
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

    public function test_get_kost(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/kost"), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

    public function test_create_kost(){
        $body = [
            "name_kost" => $this->faker->company,
            "location" => $this->faker->state,
            "price" => $this->faker->randomNumber(2),
            "lat" => "",
            "lon" => "",
            "status" => 1,
            "category" => "A",
            "phone" => $this->faker->streetAddress,
            "address" => $this->faker->streetAddress 
        ];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->post(url("/api/v1/kost/"), $body, $header);
        $GLOBALS['v_premium'] = json_decode($response->content(),true);
        $response->assertStatus(200);
    }

    public function test_get_kost_location(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/kost?location=".$GLOBALS['v_premium']['location']), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

    public function test_get_kost_name(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/kost?name_kost=".$GLOBALS['v_premium']['name_kost']), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

    public function test_get_kost_price(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/kost?price=".$GLOBALS['v_premium']['name_kost']), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

    public function test_get_kost_price_sort(){
        $body = [];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->get(url("/api/v1/kost?sort_by=price&sort_order=desc"), $header);
        $GLOBALS['credit_premium'] = json_decode($response->content(),true);
        if(empty($GLOBALS['credit_premium']['data']));{
            $response->assertOK();
        }
    }

    public function test_update_credit(){
        $body = [
            "name_kost" => $this->faker->company,
            "location" => $this->faker->state,
            "price" => $this->faker->randomNumber(2),
            "lat" => "",
            "lon" => "",
            "status" => 1,
            "category" => "A",
            "phone" => $this->faker->streetAddress,
            "address" => $this->faker->streetAddress 
        ];
        $header['Accept'] = "application/json";
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->put(url("/api/v1/kost/".$GLOBALS['v_premium']['kost_id']), $body, $header);
        $response->assertStatus(200);
    }

    public function test_delete_credit(){
        $header['Accept'] = "application/json";
        $body = [];
        $header['Authorization'] = "Bearer ".$GLOBALS['l_premium']['token'];
        $response = $this->delete(url("/api/v1/kost/".$GLOBALS['v_premium']['kost_id']),$body, $header);
        $response->assertStatus(200);
    }

}

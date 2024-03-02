<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id_card_number" => "required|exists:societies,id_card_number",
            "password" => "required"
        ]);

        if($validator->fails()){
            return $this->createResponseValidate($validator->errors());
        }

        $user = Society::where('id_card_number', $request->id_card_number)->first();

        if(!$user || $request->password != $user->password){
            return $this->createResponseAPI(401, "ID card number or password is incorrect", null);
        }

        $society = Society::with('regional')->where("id_card_number", $request->id_card_number)->first();
        $token = md5($society->id_card_number);
        $society->update(['login_tokens' => $token]);

        $data = $society;
        $data["token"] = $token;

        return $this->createResponseAPI(200, "Log In society succes", $data);
    }

    public function logout(Request $request)
    {
        $society = Society::where('login_tokens', $request->token)->first();

        if(is_null($society)){
            return $this->createResponseInvalidToken("Invalid Token");
        }

        $society->login_tokens = null;
        $society->save();

        return $this->createResponseAPI(200, "Logout success", null);
    }
}

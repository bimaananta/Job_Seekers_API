<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $society = Society::where('login_tokens', $request->token)->first();

        if(is_null($society)){
            return $this->createResponseInvalidToken("Unauthorized user");
        }

        $validation = Validation::with('category')->where('society_id', $society->id)->first();

        if(is_null($validation)){
            return $this->createResponseAPI(422, "Validation request not found", null);
        }

        return $this->createResponseAPI(200, "Get validation request success", $validation);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "work_experience" => "required",
            "job_category_id" => "required|exists:job_categories,id",
            "job_position" => "required",
            "reason_accepted" => "required"
        ]);

        if($validator->fails()){
            return $this->createResponseValidate($validator->errors());
        }

        $society = Society::where('login_tokens', $request->token)->first();

        if(is_null($society)){
            return $this->createResponseInvalidToken("Unathorized user");
        }

        $validation = new Validation();
        $validation->work_experience = $request->work_experience;
        $validation->job_category_id = $request->job_category_id;
        $validation->job_position = $request->job_position;
        $validation->reason_accepted = $request->reason_accepted;
        $validation->society_id = $society->id;
        
        try{
            $validation->save();
        }catch(\Exception $e){
            return $this->createResponseAPI(422, "Failed to sent validation request".$e->getMessage(), null);
        }

        return $this->createResponseAPI(200, "Request data validation sent successfull", $validation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Validation $validation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Validation $validation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Validation $validation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Validation $validation)
    {
        //
    }
}

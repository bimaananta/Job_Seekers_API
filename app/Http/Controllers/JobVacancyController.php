<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $society = $this->isValidToken($request->token);

        if(!$society){
            return $this->createResponseInvalidToken("Unauthorized user");
        }

        $validation = Validation::where('society_id', $society->id)->first();

        $vacancies = JobVacancy::with('category', 'available_position')->where('job_category_id', $validation->job_category_id)->get();

        return response()->json([
            "vacancies" => $vacancies
        ], 200);
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
        $society = Society::where('login_tokens', $request->token)->first();

        if(is_null($society)){
            return $this->createResponseInvalidToken("Unauthorized user");
        }

        $validator = Validator::make($request->all(), [
            "job_category_id" => "required|exists:job_categories,id",
            "company" => "required",
            "address" => "required",
            "description" => "required"
        ]);

        if($validator->fails()){
            return $this->createResponseValidate($validator->errors());
        }

        $vacancy = JobVacancy::create($request->all());

        return response()->json([
            "message" => "Create job vacancy success",
            "data" => $vacancy
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        if(!$this->isValidToken($request->token)){
            return $this->createResponseInvalidToken("Unauthorized user");
        }

        $vacancy = JobVacancy::with('category', 'available_position')->find($id);

        if(is_null($vacancy)){
            return response()->json([
                "message" => "Job Vacancy not found!"
            ], 404);
        }

        return response()->json([
            "vacancy" => $vacancy
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        //
    }
}

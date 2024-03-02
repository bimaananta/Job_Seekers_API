<?php

namespace App\Http\Controllers;

use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApplySocietyController extends Controller
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

        $appliedJobs = JobApplySociety::with(['vacancy' => function($vacancy){
            $vacancy->with('category');
        }, 'position' => function($position){
            $position->with('positions');
        }])->where('society_id', $society->id)->get();

        $datas = [];

        foreach($appliedJobs as $appliedJob){
            $newData = $appliedJob;
            $data['vacancy'] = $newData["vacancy"];
            $data['position'] = $newData["position"];
            $datas[] = $data;
        }

        if(is_null($appliedJobs)){
            return response()->json([
                "message" => "applied job not found"
            ], 404);
        }

        return response()->json($datas, 200);
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
        $society = $this->isValidToken($request->token);

        if(!$society){
            return $this->createResponseInvalidToken("Unauthorized user");
        }

        $validation = Validation::where("society_id", $society->id)->first();

        if(is_null($validation) || $validation->status != "accepted"){
            return response()->json([
                "message" => "Your data validator must be accepted by validator before"
            ], 401);
        }

        $jobApplied = JobApplySociety::where('society_id', $society->id)->first();

        if(!is_null($jobApplied)){
            return response()->json([
                "message" => "Application for a job can only be once"
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            "vacancy_id" => "required|exists:job_vacancies,id",
            "positions" => "required|array",
            "notes" => "required"
        ]);

        if($validator->fails()){
            return $this->createResponseValidate($validator->errors());
        }

        $jobApply = JobApplySociety::create(["notes" => $request->notes, "society_id" => $society->id, "job_vacancy_id" => $request->vacancy_id]);

        foreach($request->positions as $position){
            $jobApplyPosition = new JobApplyPosition();

            $jobApplyPosition->society_id = $society->id;
            $jobApplyPosition->job_vacancy_id = $request->vacancy_id;
            $jobApplyPosition->position_id = $position;
            $jobApplyPosition->job_apply_societies_id = $jobApply->id;

            try{
                $jobApplyPosition->save();
            }catch(\Exception $e){
                return response()->json([
                    "message" => "Failed to send application" . $e->getMessage()
                ], 422);
            }
        }

        return response()->json([
            "message" => "Applying for job successful"
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplySociety $jobApplySociety)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplySociety $jobApplySociety)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplySociety $jobApplySociety)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplySociety $jobApplySociety)
    {
        //
    }
}

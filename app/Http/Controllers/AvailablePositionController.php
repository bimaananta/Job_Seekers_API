<?php

namespace App\Http\Controllers;

use App\Models\AvailablePosition;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvailablePositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            "job_vacancy_id" => "required|exists:job_vacancies,id",
            "position" => "required",
            "capacity" => "required|numeric",
            "apply_capacity" => "required|numeric"
        ]);

        if($validator->fails()){
            return $this->createResponseValidate($validator->errors());
        }

        $availablePosition = AvailablePosition::create($request->all());

        return response()->json([
            "message" => "Create available position success",
            "data" => $availablePosition
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(AvailablePosition $availablePosition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvailablePosition $availablePosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvailablePosition $availablePosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvailablePosition $availablePosition)
    {
        //
    }
}

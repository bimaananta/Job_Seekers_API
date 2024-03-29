<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;

class SocietyController extends Controller
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

        return response()->json($society, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Society $society)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Society $society)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society)
    {
        //
    }
}

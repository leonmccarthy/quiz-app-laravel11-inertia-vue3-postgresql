<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        // UPDATE THE ANSWERS
        $answers = $request->all();

        foreach($answers as $a){
            $id = $a['id'];
            $updatedAnswer = Answer::findOrFail($id);
            $updatedAnswer->answers = $a['answers'];
            $updatedAnswer->correct_answer = $a['correct_answer'];
            $updatedAnswer->save();
        }

        return redirect('/questions')->with('success', 'Answers updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}

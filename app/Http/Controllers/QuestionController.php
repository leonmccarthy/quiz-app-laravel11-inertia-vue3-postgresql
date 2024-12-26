<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //PASS IN QUESTIONS TO FRONTEND
        $questions = Question::with('answers')->get();
        return Inertia::render('Questions', [
            'questions'=>$questions
        ]);
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
        $request_data = $request->all();
        $question = $request_data['question'];

        // SAVE QUESTION
        $newQuestion = new Question();
        $newQuestion->question = $question;
        $newQuestion->save();

        // SAVE ANSWERS
        $answers = $request_data['answers'];

        foreach ($answers as $answer) {
            $newAnswer = new Answer();
            $newAnswer->answers = $answer['answer'];
            $newAnswer->question_id = $newQuestion->id;
            $newAnswer->correct_answer = $answer['correct_answer'];
            $newAnswer->save();
        }

        return redirect('/questions')->with('success', 'Question and Answer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}

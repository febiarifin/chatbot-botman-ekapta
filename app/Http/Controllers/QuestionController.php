<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Manjemen Pertanyaan',
            'active' => 'question',
            'questions' => Question::with(['answers'])->get(),
        ];
        return view('pages.question.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_text' => ['required'],
        ]);
        if ($request->user_info) {
            $validatedData['user_info'] = $request->user_info;
        }
        $question = Question::create($validatedData);
        Toastr::success(Auth::user() ? 'Pertanyaan berhasil ditambahkan' : 'Terimakasih atas kontribusinya', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route(Auth::user() ? 'questions.edit' : 'home', $question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $data = [
            'title' => 'Edit Pertanyaan',
            'active' => 'question',
            'question' => $question,
            'answers' => $question->answers()->paginate(10),
        ];
        return view('pages.question.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $validatedData = $request->validate([
            'question_text' => ['required'],
        ]);
        $question->update($validatedData);
        Toastr::success('Pertanyaan berhasil diupdate', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        Toastr::success('Pertanyaan berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}

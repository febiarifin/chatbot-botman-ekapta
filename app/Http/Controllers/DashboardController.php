<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $questions = Question::orderBy('counter', 'desc')->take(10)->get();
        $labels = [];
        $datas = [];
        foreach ($questions->shuffle() as $question) {
            $labels[] = substr($question->question_text, 0,5).'...'.substr($question->question_text, - 5);
            $datas[] = $question->counter;
        }
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'questions' => Question::all(),
            'answers' => Answer::all(),
            'questions_new' => Question::orderBy('created_at','desc')
            ->where('user_info', '!=', null)
            ->take(10)
            ->get(),
            'labels_question' => $labels,
            'datas_question' => $datas,
            'counter' => Question::sum('counter'),
        ];
        return view('pages.dashboard.index', $data);
    }

}

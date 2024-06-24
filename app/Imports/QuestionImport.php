<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $question = Question::where('question_text', 'like', '%' . $row['question'] . '%')->first();
        $answer = Answer::where('answer_text', 'like', '%' . $row['answer'] . '%')->first();
        if ($question) {
            if (!$answer) {
                Answer::create([
                    'answer_text' => $row['answer'],
                    'question_id' => $question->id,
                ]);
            }
        }else{
            $question = Question::create([
                'question_text' => $row['question'],
                'counter' => $row['counter'],
            ]);
            if (!$answer) {
                Answer::create([
                    'answer_text' => $row['answer'],
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}

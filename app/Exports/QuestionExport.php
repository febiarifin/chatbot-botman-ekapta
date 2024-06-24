<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuestionExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Question::with('answers')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'question',
            'answer',
            'counter',
        ];
    }

    /**
     * @param mixed $question
     * @return array
     */
    public function map($question): array
    {
        $mapped = [];

        foreach ($question->answers as $answer) {
            $mapped[] = [
                $question->question_text,
                $answer->answer_text,
                $question->counter,
            ];
        }

        if (empty($mapped)) {
            $mapped[] = [
                $question->question_text,
                '',
                $question->counter,
            ];
        }

        return $mapped;
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 100, // Lebar kolom untuk 'Question'
            'B' => 150, // Lebar kolom untuk 'Answer'
            'C' => 10, // Lebar kolom untuk 'Answer'
        ];
    }
}

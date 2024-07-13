<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        // $question = Question::create(['question_text' => 'What is Laravel?']);
        // $question->answers()->createMany([
        //     ['answer_text' => 'Laravel is a PHP framework.'],
        //     ['answer_text' => 'It is used for web development.']
        // ]);

        // $question = Question::create(['question_text' => 'What is PHP?']);
        // $question->answers()->createMany([
        //     ['answer_text' => 'PHP is a programming language.'],
        //     ['answer_text' => 'It stands for Hypertext Preprocessor.']
        // ]);
    }
}

<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Http\Request;
use App\Models\Question;
use Phpml\ModelManager;

class BotManController extends Controller
{

    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $config = [];
        $botman = BotManFactory::create($config);

        $botman->hears('{params}', function (BotMan $bot, $params) {
            $bot->typesAndWaits(1);
            $question = $this->processParams($params);
            if ($question) {
                $question->increment('counter');

                $answers = $question->answers()->pluck('answer_text');

                if (count($answers) != 0) {
                    foreach ($answers as $answer) {
                        $bot->reply($answer);
                    }
                } else {
                    $bot->reply('Maaf, jawabannya tidak tersedia saat ini.');
                }
            } else {
                $bot->reply('Maaf, jawabannya tidak tersedia saat ini.');
            }
        });

        $botman->listen();
    }

    public function askOpenAI($question)
    {
        $modelManager = new ModelManager();
        $classifier = $modelManager->restoreFromFile(storage_path('model/mlp_classifier.model'));

        // Ubah pertanyaan menjadi array kata-kata dan konversi ke float
        $tokens = explode(' ', $question);
        $sample = array_map('floatval', $tokens);

        // Prediksi jawaban
        $prediction = $classifier->predict([$sample]);
        if ($prediction) {
            return $prediction;
        }
        return 'none';
    }

    function processParams($params)
    {
        // Daftar kata tanya 5W1H dan kata umum lainnya
        $stopWords = [
            'apa', 'siapa', 'kapan', 'dimana', 'mengapa', 'bagaimana',
            'cara', 'untuk', 'dan', 'atau', 'yang', 'dari', 'di', 'ke',
            'pada', 'dengan', 'oleh', 'sebagai', 'saya', 'aku', 'kamu'
        ];

        // Menghapus semua karakter spesial
        $params = preg_replace('/[^\w\s]/', '', $params);

        // Pisahkan parameter menjadi array kata
        $words = explode(' ', strtolower($params));

        // Hapus kata yang ada di daftar stopWords
        $filteredWords = array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords);
        });

        // Mengembalikan kata-kata yang tersisa dalam bentuk array
        $filteredWords;

        $questionCounts = [];
        foreach ($filteredWords as $word) {
            $questions = Question::where('question_text', 'like', '%' . $word . '%')->get();

            foreach ($questions as $question) {
                $questionId = $question->id;

                if (isset($questionCounts[$questionId])) {
                    $questionCounts[$questionId]++;
                } else {
                    $questionCounts[$questionId] = 1;
                }
            }
        }

        arsort($questionCounts); // Mengurutkan berdasarkan nilai tertinggi

        if (!empty($questionCounts)) {
            $topQuestionId = key($questionCounts); // ID pertanyaan dengan porobabilitas terbanyak
            $topQuestion = Question::find($topQuestionId); // Ambil objek
            return $topQuestion;
        } else {
            return null;
        }
    }
}

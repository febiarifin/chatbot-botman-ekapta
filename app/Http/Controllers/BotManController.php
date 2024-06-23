<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Http;

class BotManController extends Controller
{

    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $config = [];
        $botman = BotManFactory::create($config);
        $botman->hears('{question}', function (BotMan $bot, $question) {
            $bot->typesAndWaits(2);
            $question = Question::where('question_text', 'like', '%' . $question . '%')->first();
            if ($question) {
                $question->increment('counter');
                $answers = $question->answers()->pluck('answer_text');
                if (count($answers) != 0) {
                    foreach ($answers as $answer) {
                        $bot->reply($answer);
                    }
                } else {
                    $bot->reply('Maaf, jawabannya tidak tersedia saat ini.');
                    // $bot->reply($this->askOpenAI($question));
                }
            } else {
                $bot->reply('Maaf, jawabannya tidak tersedia saat ini.');
                // $bot->reply($this->askOpenAI($question));
            }
        });
        $botman->listen();
    }

    public function askOpenAI($question)
    {
        $userContent = $question;
        $apiKey = 'b4e41ee58f804bd4a24b4d6ed24a4897 ';
        $endpoint = 'https://api.aimlapi.com/chat/completions';

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post($endpoint, [
            'model' => 'mistralai/Mistral-7B-Instruct-v0.2',
            'messages' => [
                ['role' => 'user', 'content' => $userContent],
            ],
            'temperature' => 0.7,
            'max_tokens' => 128,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $responseText = $responseData['choices'][0]['message']['content'] ?? 'No response text available.';
        } else {
            $responseText = 'Failed to get response from API.';
        }

        return $responseText;
    }
}

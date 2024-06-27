<?php

// app/Console/Commands/TrainModel.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Classification\MLPClassifier;
use Phpml\ModelManager;
use App\Models\Question;

class TrainModel extends Command
{
    protected $signature = 'model:train';
    protected $description = 'Train the neural network model';

    public function handle()
    {
        // Ambil data dari database
        $questions = Question::with('answers')->get();

        // Persiapkan samples dan labels
        $samples = [];
        $labels = [];

        foreach ($questions as $question) {
            if (count($question->answers) != 0) {
                // Ubah pertanyaan menjadi array kata-kata
                $tokens = explode(' ', $question->question_text);
                $sample = array_map('floatval', $tokens); // Ubah token menjadi float
                $samples[] = $sample;
                // foreach ($question->answers as $answer) {
                //     $labels[] = $answer->answer_text;
                // }
                $labels[] = $question->answers()->first()->answer_text;
            }
        }
        // $this->info(print_r($labels));
        // Buat dan latih model jika ada data yang diberikan
        if (!empty($samples)) {
            // $mlp = new MLPClassifier(count($samples[0]), [10], array_unique($labels));
            $mlp = new MLPClassifier(count($samples[0]), [10], $labels);
            $mlp->train($samples, $labels);

            // Simpan model
            $modelManager = new ModelManager();
            $modelManager->saveToFile($mlp, storage_path('model/mlp_classifier.model'));

            $this->info('Model trained and saved successfully.');
        } else {
            $this->error('No data found to train the model.');
        }
    }
}

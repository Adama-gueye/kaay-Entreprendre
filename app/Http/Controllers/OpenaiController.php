<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class OpenaiController extends Controller
{
    public function index(Request $request)
    {
        $content = $request->get('content');
        $client = OpenAI::client(config('openai.api-key'));

        $response = $client
            ->completions()
            ->create([
                "model" => "text-davinci-003",
                "temperature" => 0,
                "frequency_penalty" => 0,
                'max_tokens' => 600,
                'prompt' => "repond a mes question  $content",
            ]);

        // You might want to do something with the $response here
    }
}

<?php

require_once('./config.php');

// Set up parameters for the assistant
$language = "english";
$tone = "encouraging";
$tool = "tweet";
$number = 3;
$details = "";

// Call the assistant method
try {
    $text = "I am a software developer";
    $response = $tinq->rewrite($text, [
        'lang' => 'arabic',
        'tone' => 'neutral',
        'tool' => 'rewriter',
    ]);
    // Print the response
    echo "Assistant Response:\n";
    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}



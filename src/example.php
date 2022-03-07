<?php

use Tinq\TinqClient;

require_once('../src/TinqClient.php');

// API Key and username can be found here: https://tinq.ai/dashboard/profile
// username is optional.
$tinq = new Tinq\TinqClient('<api_key>', '<username>');

$reviews = [
    'The apartment was as advertised and Frank was incredibly helpful through the entire process. I would definitely recommend this place.',
    'This was the worse experience that I had on this app. Trully disapointing',
    'Frank was great, the apartment has everything we need, including parking and the neighborhood is lovely!  So close to the water, restaurants, train and the airport (8 min walk!)',
    'This is really a great location. The street is quiet and the room is really great. The bed is confortable. Terry is really helpfull. Enjoy.',
    'It wsd decent. Nothing more to add.',
];

$analysis = [];
foreach($reviews as $review) {

        $sentimentAnalysis = $tinq->sentiments($review);
        $sentiment = $sentimentAnalysis['sentiment'];

        $analysis[] = [
            'review' => $review,
            'sentiment' => $sentiment
        ];
}

var_dump($analysis);
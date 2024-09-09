<?php

require_once('./config.php');

try {
    $text = "
    One hundred and twenty runners stood in a clearing overlooking the Mississippi River,
    listening as a man with a curly gray beard needled them.
    He checked his watch; an unlit cigarette dangled from his fingers.
    “Thirty seconds,” he announced to the crowd. “You're running out of time to change your mind.”
    ";
    $response = $tinq->summarize($text);
    // Print the response
    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}



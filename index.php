<?php
// API Key and Model Initialization
$apiKey = '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';
$model = 'gpt-4o-mini';

// Initialize cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
));



// Construct the prompt
$prompt = "Given the following content, please categorize it based on the predefined categories:\n\n";
$prompt .= "Categories:\n" . json_encode($categories, JSON_PRETTY_PRINT) . "\n\n";
// $prompt .= "Content:\n" . $content . "\n\n"; // Uncomment to include content
$prompt .= "For each link or relevant phrase in the content, identify which category it belongs to using IDs like 'cat1_1', 'cat1_2', etc. Please ensure no more than 2 selections per category level (cat1, cat2, cat3). Additionally, suggest new category titles based on this content, including keywords and reasons for your suggestions. Output your results in JSON format.";

// Set the POST fields with the prompt
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'model' => $model,
    'messages' => array(
        array('role' => 'user', 'content' => $prompt)
    )
)));

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Output the response from the API
echo $response;
?>
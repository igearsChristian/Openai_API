<?php
//When you send a GET request from Postman (or any HTTP client) to a PHP script hosted on a web server, it triggers the execution of that PHP code.

//set up PHP to accept JSON properly
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decode JSON to associative array

    echo "<h1>Received Data</h1>";

    // Check if data was received
    if ($data) {
        foreach ($data as $key => $value) {
            echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
        }
    } else {
        echo "No data received.";
    }
}

// API Key and Model Initialization
$apiKey = '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';
$model = 'gpt-4o-mini';

// Initialize cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');

//Tells cURL to return the response as a string instead of directly outputting it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Indicates that this will be a POST request
curl_setopt($ch, CURLOPT_POST, true);

//Sets the headers for the request, including the content type (JSON) and the authorization header with the API key
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
));



// Construct the prompt

// $prompt = "Given the following content, please categorize it based on the predefined categories:\n\n";
$prompt = "hello. tell me what is gpt-4o in one line";
// $prompt .= "Categories:\n" . json_encode($categories, JSON_PRETTY_PRINT) . "\n\n";
// // $prompt .= "Content:\n" . $content . "\n\n"; // Uncomment to include content
// $prompt .= "For each link or relevant phrase in the content, identify which category it belongs to using IDs like 'cat1_1', 'cat1_2', etc. Please ensure no more than 2 selections per category level (cat1, cat2, cat3). Additionally, suggest new category titles based on this content, including keywords and reasons for your suggestions. Output your results in JSON format.";



// Set the POST fields with the prompt
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'model' => $model,
    'messages' => array(
        array('role' => 'user', 'content' => $prompt)
    )
)));

// Execute the cURL request - sending the prompt to the OpenAI API and storing the response
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode the JSON response
    $decodedResponse = json_decode($response, true);

    // Check if the response contains the expected structure
    if (isset($decodedResponse['choices'][0]['message']['content'])) {
        // Output only the content
        echo $decodedResponse['choices'][0]['message']['content'];
    } else {
        echo "No content found in the response.";
    }
}

// Close cURL session
curl_close($ch);

// Output the response from the API
$response;
?>


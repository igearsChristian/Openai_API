<?php
//postman
//post to https://cahome.igears.com.hk/ai/
//{"prompt":"what is ai"}

// API Key and Model Initialization
$apiKey = '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';
$model = 'gpt-4o-mini';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decode JSON to associative array

    echo "<h1>Data received</h1>";

    // Check if data was received
    if ($data) {
        foreach ($data as $key => $value) {
            // Store each value as a string
            $stringValue = (string)$value; // Cast to string if needed
            // echo htmlspecialchars($key) . ": " . htmlspecialchars($stringValue) . "<br>";
            // echo $stringValue;
        }
    } else {
        echo "No data received";
    }

    //Pass user input to the prompt
    $send_flag = true;
    if ($send_flag) {
        // Initialize cURL sessione
        echo "Proceeding to send to OpenAI...<br>";
        echo PHP_EOL;

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
        echo "Prompt sent to open ai: " . $stringValue;
        echo PHP_EOL;


        // $prompt = "hello. tell me what is get http request in one line";
        $prompt = $stringValue;

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

        echo PHP_EOL;
        echo PHP_EOL;
        echo PHP_EOL;

        // Output the response from the API
        echo $response;
    }
} 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // API Key and Model Initialization

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
    // $prompt = "Given the following content, please categorize it based on the predefined categories:\n\n";
    $prompt = "hello. tell me what is http in one line";
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

    // Execute the cURL request
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

    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
    // Output the response from the API
    echo $response;
}
?>


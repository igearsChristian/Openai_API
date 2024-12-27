<?php
//Sample postman to https://cahome.igears.com.hk/ai/
// {
//     "key" : "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",
//     "model" : "gpt-4o-mini",
//     "store": "true",
//     "message" : [
//         {"role":"assistant", "content":"what is ai in one line"}
//     ]
// } 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decode JSON to associative array

    echo "<h3>Data received</h3>";

    // Check if data was received
    if ($data) {
        echo PHP_EOL;
        // Extract values from the data array
        $apiKey = isset($data['key']) ? $data['key'] : null;
        echo "Key: " . htmlspecialchars($apiKey) . PHP_EOL;
    
        $model = isset($data['model']) ? $data['model'] : null;
        echo "Model: " . htmlspecialchars($model) . PHP_EOL;
    
        $store = isset($data['store']) ? $data['store'] : null;
        echo "Store: " . htmlspecialchars($store) . PHP_EOL;
    
        $message = isset($data['message']) ? $data['message'] : null;
        // echo "Message: " . json_encode($message, JSON_PRETTY_PRINT) . PHP_EOL; // Use json_encode for better formatting
        foreach ($data['message'] as $msg) {
            // Extract content from each message
            $role = isset($msg['role']) ? $msg['role'] : null;
            $content = isset($msg['content']) ? $msg['content'] : null;
            $output = "AI's Role: " . htmlspecialchars($role) . ", Content: " . htmlspecialchars($content);
            echo $output . PHP_EOL; // Output the formatted string
        }

    
    } else {
        echo "No data received";
    }

    //Pass user input to the prompt
    $send_flag = true;
    if (!$send_flag) {
        echo PHP_EOL;
        echo $response;
    }

    if ($send_flag) {
        echo "Proceeding to send to OpenAI..." . PHP_EOL;

        // Initialize cURL sessione
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $store); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ));



        // Construct the prompt
        echo "Prompt sent to open ai: " . $content . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;
        echo "AI's reply: " . PHP_EOL;


        // $prompt = "hello. tell me what is get http request in one line";
        $prompt = $content;

        // Set the POST fields with the prompt
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'model' => $model,
            'messages' => array(
                array('role' => $role , 'content' => $prompt)
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
            if (!isset($decodedResponse['choices'][0]['message']['content'])) {
                echo "No content found in the response.";
            }
        }

        // Close cURL session
        curl_close($ch);

        // Output the response from the API
        echo $response;
    }
} 

?>


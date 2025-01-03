<?php
// {
//     "key" : "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",
//     "model" : "gpt-4o-mini",
//     "store": "true",
//     "message" : [
//         {"role":"assistant", "content":"what is ai in one line"}
//     ]
// } 

// curl https://api.openai.com/v1/chat/completions \
// -H "Content-Type: application/json" \
// -H "Authorization: Bearer $OPENAI_API_KEY" \
// -d '{
//   "model": "gpt-4o-mini",
//   "messages": [
//     {
//       "role": "developer",
//       "content": "You are a helpful assistant."
//     },
//     {
//       "role": "user",
//       "content": "Hello!"
//     }
//   ]
// }

// {
//     "key" : "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",
//     "model" : "text-embedding-ada-002",
//     "input" : "cat",
//     "encoding_format": "float"
// } 

// curl https://api.openai.com/v1/embeddings \
// -H "Authorization: Bearer $OPENAI_API_KEY" \
// -H "Content-Type: application/json" \
// -d '{
//   "input": "The food was delicious and the waiter...",
//   "model": "text-embedding-ada-002",
//   "encoding_format": "float"
// }'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decode JSON to associative array

    if ($data) {
        $apiKey = isset($data['key']) ? $data['key'] : null;
        $model = isset($data['model']) ? $data['model'] : null;    
        $input  = isset($data['input']) ? $data['input'] : null;  
        $encoding_format = isset($data['encoding_format']) ? $data['encoding_format'] : null;  

    } else {
        echo "No data received";
    }

    $send_flag = true;
    if (!$send_flag) {
    }

    if ($send_flag) {
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/embeddings');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $store); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ));

        $prompt = $content;

        // Set the POST fields with the prompt
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'input' => $input,
            'model' => $model,
            'encoding_format' => $encoding_format
        )));

        // Execute the cURL request
        $response = curl_exec($ch);

        echo $response;

        // Close cURL session
        curl_close($ch);
    }
} 
?>


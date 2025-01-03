<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decode JSON to associative array

    if ($data) {
        $apiKey = isset($data['key']) ? $data['key'] : null;
        $model = isset($data['model']) ? $data['model'] : null;    
        $store = isset($data['store']) ? $data['store'] : null;   
        $message = isset($data['message']) ? $data['message'] : null;
        foreach ($data['message'] as $msg) {
            // Extract content from each message
            $role = isset($msg['role']) ? $msg['role'] : null;
            $content = isset($msg['content']) ? $msg['content'] : null;
        }    
    } else {
        echo "No data received";
    }

    $send_flag = true;
    if (!$send_flag) {
    }

    if ($send_flag) {
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $store); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ));

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

        echo $response;

        // Close cURL session
        curl_close($ch);
    }
} 
?>


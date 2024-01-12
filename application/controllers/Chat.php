<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function index()
	{
       	
	}
    
    public function ai($q)
    {

        $data = $this->sendMessage($q,$_SESSION['context']); 
        $_SESSION['data'] = $data;
       /* $gpt = $data['choices'][0]['message']['content'];
        
        echo 
            '<div class="chat-content">
                <div class="message-item">
                    <div class="bubble">' . $gpt . '</div>    
                    <div class="message-time">' . date("h:i") . '</div>    
                </div>
            </div>
            ';
        */
        print_r($data);
    }

    public function send()
    {
        $post = $_POST;
        if (!empty($_SESSION['data'])){
            $data = $_SESSION['data'];
            $new['role'] = 'user';
            $new['message'] = $post['message'];
            $data['messages'][count($data['messages'])]['role'] = 'user';
            $data['messages'][count($data['messages']) - 1]['message'] = $post['message'];
            print_r($data);
        }
        echo 
            '<div class="chat-content user">
                <div class="message-item">
                    <div class="bubble">' . $post['message'] . '</div>    
                    <div class="message-time">' . date("h:i") . '</div>    
                </div>
            </div>';

        $this->ai($post['message']);
    }

    public function chat_gpt($question)
    {
        $apiKey = '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';
        $endpoint = 'https://api.openai.com/v1/chat/completions';
        
        // Define the conversation messages with roles
        $data="";
        $messages = "";
       
        if (is_null($_SESSION['data']['error'])){
            print_r($_SESSION['data']);
            $data = $_SESSION['data'];
        } else {
            $messages = [
                [
                    "role" => "system",
                    "content" => "You work for TrinityDoors who makes 5 piece shaker cabinet doors. 
                    Your job is to give customer quotes. 
                    Asking the user for the width and height assume inches of the doors.
                    After user gives the information, calculate the square footage then quote a price of $12.60 per square feet."
                ],
                [
                    "role" => "user",
                    "content" => $question
                ]

            ];
        }
    
        
        // Construct the payload for the API request
        
        if ($data == ""){
            $data = [
                "model" => "gpt-3.5-turbo",
                "messages" => $messages
            ];
        }
        
        // Encode the data as JSON
        $postData = json_encode($data);
        
        // Set up curl options
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        
        // Execute the curl request
        $response = curl_exec($ch);
        
        // Check for errors
        if ($response === false) {
            return 'Curl error: ' . curl_error($ch);
        } else {
            // Handle the API response
            $decodedResponse = json_decode($response, true);
            return $decodedResponse;
        }
        
        // Close curl resource
        curl_close($ch);
    }


    public function sendMessage($message, $context) {
        // Construct the payload for the API request
        $apiKey = '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';
        $endpoint = 'https://api.openai.com/v1/chat/completions';
        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You work for TrinityDoors who makes 5 piece shaker cabinet doors. 
                    Your job is to give customer quotes. 
                    Asking the user for the width and height assume inches of the doors.
                    After user gives the information, calculate the square footage then quote a price of $12.60 per square feet."
                ],
                [
                    "role" => "user",
                    "content" => $message
                ]
            ],
            "context" => $context  // Include the context in the request
        ];

        // Encode the data as JSON
        $postData = json_encode($data);

        // Set up cURL options
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // Handle the API response
            $decodedResponse = json_decode($response, true);
            print_r($decodedResponse);
            // Extract and return the context for the next request
            return $decodedResponse['context'];
        }

        // Close cURL resource
        curl_close($ch);
    }


}
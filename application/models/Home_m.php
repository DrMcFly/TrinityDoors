<?php
class Home_m extends CI_Model {

	function __construct()
    {
       parent::__construct();
    }

    public function home()
    {
        $this->load->view('home/header');
        $this->load->view('home/nav');
        $this->load->view('home/parallax');
        $this->load->view('home/overview');
        $this->load->view('home/feature');
        //$this->load->view('home/work');
        $this->load->view('home/testimonials');
        $this->load->view('home/calltoaction');
        $this->load->view('home/vendors');
        $this->load->view('home/footer');
    }

    public function login()
    {
        $this->load->view('home/header');
       $this->load->view('home/nav'); 
       $this->load->view('home/parallax');
        $this->load->view('home/form');
        $this->load->view('home/footer');
    }

    public function estimate()
    {
        $data['inv'] = $this->home_m->getREST('inv');
        //print_r($data);
        $this->load->view('home/header');
        $this->load->view('home/nav');
        $this->load->view('home/shop');
        $this->load->view('home/estimate',$data);
        $this->load->view('home/footer');
    }

    public function thankyou()
    {
        $this->load->view('home/header');
        $this->load->view('home/nav');
        $this->load->view('home/thankyou');
        $this->load->view('home/footer');
    }

    public function contact()
    {
        $this->load->view('home/header');
        $this->load->view('home/nav');
        $this->load->view('home/contact');
        $this->load->view('home/footer');
    }

    public function getREST($api,$param="")
	{
        //loging
		$url = 'https://api.trinitydoors.us/api/'. $api;
        if (!empty($param)){
            $data = $param;
        }
		$data['type'] = 1;
        $data['email'] = "brent@medtrio.com";
        $data['password'] = "luyet-2011";

		$send = http_build_query($data);
		$ch = curl_init();    // initialize curl handle
		curl_setopt($ch, CURLOPT_URL,$url); // set POST target URL
		curl_setopt($ch,CURLOPT_POST, true); // set POST method
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$send);
		$result = curl_exec($ch); // run the curl to post to Converge

		$get_jason="";
		if ($result === false)
         {
            echo 'Curl error message: '.curl_error($ch).'<br>';
            echo 'Curl error code: '.curl_errno($ch);
			} else {
                $httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpstatus == 200) 
                {            
                    //$get_jason = urlencode($result);
                    $get_jason = json_decode($result); // puts json back in to php
                    
                    return $get_jason; 
                    curl_close($ch); // Close cURL
                    
                        exit;
			} else {
				$get_jason = $result;
				curl_close($ch); // Close cURL
				return $get_jason;	
			}
		}	
	}	

    public function chat_gpt($question){
       
  

        // Set your OpenAI API key and endpoint
        $apiKey = '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';
        $endpoint = 'https://api.openai.com/v1/chat/completions';
        
        // Define the conversation messages with roles
        $messages = [
            [
                "role" => "system",
                "content" => "You work for TrinityDoors who makes 5 piece shaker cabinet doors. Your job is to give customer quotes. You will ask
                the user for the width and height. You will calculate the square footage then quote a price of $12.60 per square feet. Ask the user to supply you with
                the width and height and how many doors they need."
            ],
            [
                "role" => "user",
                "content" => $question
            ]
        ];
        
        // Construct the payload for the API request
        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => $messages
        ];
        
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
        
}        
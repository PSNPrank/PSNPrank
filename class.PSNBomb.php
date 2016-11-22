<?php

/* COPYRIGHT 2016 BY PSNBOMB.org

   Project Sjonny Scholte.com

   This is our BETA V1.
   Find update's in your API panel.
                                        */

class PSNBomb {
    private $oauth;

    private $bomb_error;

    private $login_request = [
        "key" => null,
        "secret" => null
    ];

    private $bomb_request = [
        "psn" => null,
        "message" => null,
        "amount" => null,
        "accestoken" => null
    ];
    
    public function __construct($key, $secret) {
        $this->login_request['key'] = $key;
        $this->login_request['secret'] = $secret;

    }

    public function auth() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.psnbomb.org/API_FILES/V1/auth.php');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->login_request));

        $output = curl_exec($ch);

        curl_close($ch);

        if(strlen($output) < 10) {
            die('We can\'t verify your login requests! Code: ' . $output);
        }

        $this->oauth = $output;

        return true;
    }

    public function bomb($psn, $message, $amount) {
        $this->bomb_request['psn'] = $psn;
        $this->bomb_request['message'] = $message;
        $this->bomb_request['amount'] = $amount;
        $this->bomb_request['$accestoken'] = $this->oauth;
    
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.psnbomb.org/API_FILES/V1/bomb.php');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->bomb_request));

        $output = curl_exec($ch);

        curl_close($ch);

        $this->bomb_error = $output;

        return true; 
    }

    public function error() {
        return $this->bomb_error;
    }
}

?>

<?php

    define('GG_TOKEN_LINK' , 'https://oauth2.googleapis.com/token');
    define('GG_AUTH_LINK' , 'https://accounts.google.com/o/oauth2/v2/auth');
    define('GG_API_LINK' , 'https://openidconnect.googleapis.com/v1');

    class OauthGoogle{
        
        private $_client_id;
        private $_client_secret;
        private $_redirect_uri;
        private $_token;
        private $_headers = [];

        public function __construct($client_id, $client_secret, $redirect_uri){
            $this->_client_id = $client_id;
            $this->_client_secret = $client_secret;
            $this->_redirect_uri = $redirect_uri;
        }

        public function get_link_connect(){
            $link = GG_AUTH_LINK . '?scope=email&access_type=online&redirect_uri='. $this->_redirect_uri .'&response_type=code&client_id='.$this->_client_id;
            return $link;
        }

        public function set_headers($token){
            $this->_headers = [
                'Authorization: Bearer '.$token,
            ];
        }

        public function get_token($code){
            $link = GG_TOKEN_LINK. "?code=" . $code ."&client_id=". $this->_client_id ."&client_secret=". $this->_client_secret ."&redirect_uri=". $this->_redirect_uri ."&grant_type=authorization_code";
            $ch = curl_init($link);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($ch);
            curl_close($ch);

            $token = json_decode($res);
            $this->_token = $token;

            return $token->access_token;
        }

        public function getGgUser(){
            $link = GG_API_LINK. "/userinfo";
            $ch = curl_init($link);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers);

            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }

    }
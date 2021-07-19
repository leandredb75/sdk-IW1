<?php
    define('FB_OAUTH_LINK', 'https://facebook.com/v2.10/dialog/oauth');
    define('FB_GRAPH', 'https://graph.facebook.com');

    class OauthFacebook{
        
        private $_client_id;
        private $_client_secret;
        private $_redirect_uri;
        

        public function __construct($client_id, $client_secret, $redirect_uri){
            $this->_client_id = $client_id;
            $this->_client_secret = $client_secret;
            $this->_redirect_uri = $redirect_uri;
        }

        public function get_link_connect(){
            $link = FB_OAUTH_LINK. "?response_type=code"
            ."&client_id=".$this->_client_id
            ."&redirect_uri=".$this->_redirect_uri
            ."&scope=email&state=dsdsfsfds";
            return $link;
        }

        public function getFbUser($params){
            $result = file_get_contents(FB_GRAPH . "/oauth/access_token?"
                . "redirect_uri=https://localhost/fb-success"
                . "&client_id=" . $this->_client_id
                . "&client_secret=" . $this->_client_secret
                . "&" . http_build_query($params));
                
            $token = json_decode($result, true)["access_token"];
            // GET USER by TOKEN
            $context = stream_context_create([
                'http' => [
                    'method' => "GET",
                    'header' => "Authorization: Bearer " . $token
                ]
            ]);
            $result = file_get_contents(FB_GRAPH. "/me", false, $context);
            $user = json_decode($result, true);
            var_dump($user);
        
            echo '<h1>Welcome '. $user["name"] . '</h1>';
        }
    }
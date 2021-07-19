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
    }
<?php
    define('FB_OAUTH_LINK', 'https://facebook.com/v2.10/dialog/oauth');
    define('FB_GRAPH', 'https://graph.facebook.com');

    class OauthGoogle{
        
        private $_client_id;
        private $_client_secret;
        

        public function __construct($client_id, $client_secret){
            $this->_client_id = $client_id;
            $this->_client_secret = $client_secret;
        }

        public function get_link_connect(){
            $link = 'https://accounts.google.com/o/oauth2/v2/auth?
            scope=https%3A//www.googleapis.com/auth/drive.metadata.readonly&
            access_type=offline&
            include_granted_scopes=true&
            response_type=code&
            state=state_parameter_passthrough_value&
            redirect_uri=https%3A//oauth2.example.com/code&
            client_id=client_id';
            return $link;
        }

    }
<?php 
    require_once 'oauthfacebook.php';
    const CLIENT_ID_FB = "2960039270934872";
    const CLIENT_SECRET_FB = "edc0f660fdc73de629915a8e9a31c175";
    CONST REDIRECT_URI_FB = "https://localhost/fb-success";

    $facebook = new OauthFacebook(CLIENT_ID_FB,CLIENT_SECRET_FB,REDIRECT_URI_FB);

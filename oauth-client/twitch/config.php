<?php 
    require_once 'oauthtwitch.php';
    const CLIENT_SECRET_TWITCH = '2cvu5jxrjvpccyb1mnj18sa05nzafc';
    const CLIENT_ID_TWITCH = 'zr3s3c14r5kmc1tb26r25scrktjg4k';
    CONST REDIRECT_URI_TWITCH = "https://localhost/tw-success";
    const SCOPES_TWITCH = 'user:read:broadcast';

    $twitch = new OAuthTwitch(
        CLIENT_ID_TWITCH,
        CLIENT_SECRET_TWITCH,
        REDIRECT_URI_TWITCH,
        SCOPES_TWITCH
    );

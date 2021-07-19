<?php
    require_once 'oauthgoogle.php';
    const GOOGLE_ID = '"765830828130-6cqo4j6i48mcgbn3lcdfr0a39pmppiql.apps.googleusercontent.com';
    const GOOGLE_SECRET = 'cvqccyNwqXPK1__1LTFwuhWM';
    const GOOGLE_REDIRECT = 'https://localhost/gg-success';

    $google = new OauthGoogle(GOOGLE_ID,GOOGLE_SECRET, GOOGLE_REDIRECT);

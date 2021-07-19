<?php 

session_start();

require_once 'oauthtwitch.php';
require_once 'config.php';

$oauth->set_headers($_SESSION['token']);

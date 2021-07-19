<?php
const CLIENT_ID = "client_606c5bfe886e14.91787997";
const CLIENT_SECRET = "2ce690b11c94aca36d9ec493d9121f9dbd5c96a5";

session_start();

require_once 'twitch/config.php';
require_once 'twitch/oauthtwitch.php';

require_once 'facebook/config.php';
require_once 'facebook/oauthfacebook.php';

$linkTwitch = $twitch->get_link_connect();
$linkFacebook = $facebook->get_link_connect();


function getUser($params)
{
    $result = file_get_contents("http://oauth-server:8081/token?"
        . "client_id=" . CLIENT_ID
        . "&client_secret=" . CLIENT_SECRET
        . "&" . http_build_query($params));
    $token = json_decode($result, true)["access_token"];
    // GET USER by TOKEN
    $context = stream_context_create([
        'http' => [
            'method' => "GET",
            'header' => "Authorization: Bearer " . $token
        ]
    ]);
    $result = file_get_contents("http://oauth-server:8081/api", false, $context);
    $user = json_decode($result, true);
    var_dump($user);
    echo '<h1>Welcome '. $user["firstname"] .' ' . $user["lastname"] . '</h1>';

}

$route = strtok($_SERVER['REQUEST_URI'], '?');
switch ($route) {
    case '/auth-code':
        // Gérer le workflow "authorization_code" jusqu'à afficher les données utilisateurs
        echo '<h1>Login with Auth-Code</h1>';
        echo "<a href='http://localhost:8081/auth?"
            . "response_type=code"
            . "&client_id=" . CLIENT_ID
            . "&scope=basic&state=dsdsfsfds'>Login with oauth-server</a><br>";
        echo "<a href=". $linkFacebook . ">Login with facebook </a><br>";
        echo "<a href=". $linkTwitch .">Login with Twitch</a><br>";
        break;
    case '/success':
        // GET CODE
        ["code" => $code, "state" => $state] = $_GET;
        // ECHANGE CODE => TOKEN
        getUser([
            "grant_type" => "authorization_code",
            "code" => $code
        ]);
        break;
    case '/fb-success':
        // GET CODE
        ["code" => $code, "state" => $state] = $_GET;
        // ECHANGE CODE => TOKEN
        $facebook->getFbUser([
            "grant_type" => "authorization_code",
            "code" => $code
        ]);
        break;
    case '/error':
        ["state" => $state] = $_GET;
        echo "Auth request with state {$state} has been declined";
        break;
    case '/tw-success':
        if(!empty($_GET['code'])){
            $code = htmlspecialchars($_GET['code']);
            $token = $twitch->get_token($code);
            $_SESSION['token'] = $token;
            $twitch->set_headers($_SESSION['token']);
            $query = $twitch->getTwUser();
            print_r($query);
        }
        break;
    case '/tw-error':
        ["state" => $state] = $_GET;
        echo "Auth request with state {$state} has been declined";
        break;
    case '/password':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            ['username' => $username, 'password' => $password] = $_POST;
            getUser([
                "grant_type" => "password",
                "username" => $username,
                "password" => $password,
            ]);
        } else {
            // Gérer le workflow "password" jusqu'à afficher les données utilisateurs
            echo "<form method='post'>";
            echo "Username <input name='username'>";
            echo "Password <input name='password'>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";
        }
        break;
    default:
        echo 'not_found leandre';
        break;
}

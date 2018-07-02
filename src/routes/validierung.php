<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use ReallySimpleJWT\Token;

// POST Login-Validierung
$app->post('/api/validierung', function(Request $request, Response $response){
    
    $name = $request->getParam('username');   
    $password = md5($request->getParam('password'));

    $sql = "SELECT ID FROM nutzer WHERE Name='$name' AND Passwort='$password'";

    
    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
    
        $userID = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($userID == null){

            echo json_encode("0");
        }
        else{
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token ist eine Stunde lang gültig

            $token = Token::getToken($userID, '@SuperSecretKey123!', $tokenExpiration, 'http://solution-ticket-system/api/validierung');
        
            $db = null;
            echo json_encode($token);
        }
    } catch(PDOException $e){
        echo json_encode("0");
        //echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

// GET Validierung für Token
$app->get('/api/validierung', function(Request $request, Response $response){

    $header = $request->getHeader('HTTP_AUTHORIZATION');
    $token = substr(implode("", $header),7);

    try{

        $result = Token::validate($token, '@SuperSecretKey123!');

        echo json_encode("1");

    } catch(Exception $e){

        echo "0";
        //echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


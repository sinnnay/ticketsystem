<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// POST neuen Nutzer
$app->post('/api/nutzer', function(Request $request, Response $response){
    $Name = $request->getParam('registerUsername');   
    $Passwort = md5($request->getParam('registerPassword'));
    
    $sql1 = "SELECT * FROM nutzer WHERE Name = '$Name'";
    $sql2 = "INSERT INTO nutzer (Name, Passwort) VALUES (:Name, :Passwort)";

    try{       

        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql1);

        $nutzer = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        if(!empty($nutzer)){

            echo json_encode("0");
        }

        else{

            $db = new db();

            $db = $db->connect();

            $stmt = $db->prepare($sql2);

            $stmt->bindParam(':Name', $Name);
            $stmt->bindParam(':Passwort', $Passwort);
            
            $stmt->execute();

            echo json_encode("1");
        }
    } catch(PDOException $e){
        echo json_encode("0");
        //echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// GET einzelnen Nutzer mit Param
$app->get('/api/nutzer', function(Request $request, Response $response){
    $name = $request->getParam('name');
    $sql = "SELECT * FROM nutzer WHERE Name = $name";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $ticket = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($ticket);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// GET einzelnen Nutzer
$app->get('/api/nutzer/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM nutzer WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $ticket = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($ticket);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// DELETE Ticket
$app->delete('/api/nutzer/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM nutzer WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Nutzer gelöscht"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

    


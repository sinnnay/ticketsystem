<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// GET alle Prioritäten
$app->get('/api/prioritaeten', function(Request $request, Response $response){
    $sql = "SELECT * FROM prioritaet";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $prioritaeten = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($prioritaeten);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

// GET einzelne Priorität
$app->get('/api/prioritaet/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM prioritaet WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $prioritaet = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($prioritaet);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


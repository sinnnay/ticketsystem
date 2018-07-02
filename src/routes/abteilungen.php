<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// GET alle Abteilungen
$app->get('/api/abteilungen', function(Request $request, Response $response){
    $sql = "SELECT * FROM Abteilung";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $abteilungen = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($abteilungen);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

// GET einzelne Abteilung
$app->get('/api/abteilung/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM Abteilung WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $abteilung = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($abteilung);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// POST Abteilung
$app->post('/api/abteilung', function(Request $request, Response $response){
    $ID = $request->getParam('ID');
    $Name = $request->getParam('Name');   
    
    
    $sql = "INSERT INTO Abteilung (ID, Name) VALUES (:ID,:Name)";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':Name', $Name);
        
        $stmt->execute();

        echo '{"notice": {"text": "Abteilung hinzugefügt"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// DELETE Abteilung
$app->delete('/api/abteilung/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM Abteilung WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Abteilung gelöscht"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
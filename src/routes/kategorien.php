<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// GET alle Kategorien
$app->get('/api/kategorien', function(Request $request, Response $response){
    $sql = "SELECT * FROM kategorie";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $kategorien = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($kategorien);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

// GET einzelne Kategorie
$app->get('/api/kategorie/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM kategorie WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $kategorie = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($kategorie);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// POST Kategorie
$app->post('/api/kategorie', function(Request $request, Response $response){
    $ID = $request->getParam('ID');
    $Name = $request->getParam('Name');   
    
    
    $sql = "INSERT INTO kategorie (ID, Name) VALUES (:ID,:Name)";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':Name', $Name);
        
        $stmt->execute();

        echo '{"notice": {"text": "Kategorie hinzugefügt"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// DELETE Abteilung
$app->delete('/api/kategorie/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM kategorie WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Kategorie gelöscht"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
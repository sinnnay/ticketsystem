<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ReallySimpleJWT\Token;

// GET alle Tickets
$app->get('/api/tickets', function(Request $request, Response $response){
    
    $sql = "SELECT t.ID,t.Name,p.Level as Prioritaet,t.kategorie as Kategorie,t.Betreff, a.Name as Abteilung from Ticket t inner join abteilung a on t.abteilung=a.ID join prioritaet p on t.prioritaet=p.ID";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql);
        $tickets = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($tickets);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});


// POST Ticket
$app->post('/api/ticket', function(Request $request, Response $response){

    $header = $request->getHeader('HTTP_AUTHORIZATION');
    $token = substr(implode("", $header),7);
    $result = Token::getPayload($token);
    $json = json_decode($result, true);
    $userID = $json['user_id'];
    $userID_Value = implode("",array_column($userID, 'ID'));
    
    //echo json_encode($userID_Value);
    $sql1 = "SELECT Name FROM nutzer WHERE ID = $userID_Value";

    //echo json_encode($sql1);
    $Kategorie = $request->getParam('category');
    $Prioritaet = $request->getParam('priority');   
    $Betreff = $request->getParam('subject');
    $Beschreibung = $request->getParam('description');   
    $Abteilung = $request->getParam('department');
    
    try{

        $db = new db();

        $db = $db->connect();

        $stmt = $db->query($sql1);

        //echo json_encode($stmt);
        $Name = $stmt->fetchAll(PDO::FETCH_OBJ);
        //echo json_encode($Name);

        //$json = json_decode($Name, true);
        $Name = $Name[0];
        $key = "Name";
        $Name = $Name->$key;
       // echo json_encode($Name);
        if($Name == null){
            echo json_encode("0");
        }

        $sql2 = "INSERT INTO ticket (Name, Kategorie, Prioritaet, Betreff, Beschreibung, Abteilung) VALUES (:Name, :Kategorie, :Prioritaet, :Betreff, :Beschreibung, :Abteilung)";
       // echo json_encode($sql2);
        $db = null;

        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql2);
       // echo json_encode($stmt);
        $stmt->bindParam(':Name', $Name);
        $stmt->bindParam(':Kategorie', $Kategorie);
        $stmt->bindParam(':Prioritaet', $Prioritaet);
        $stmt->bindParam(':Betreff', $Betreff);
        $stmt->bindParam(':Beschreibung', $Beschreibung);
        $stmt->bindParam(':Abteilung', $Abteilung);
        
        $stmt->execute();

        echo json_encode("1");
        //echo '{"notice": {"text": "Ticket hinzugefügt"}';
    } catch(PDOException $e){
        echo json_encode("0");
        //echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// DELETE Ticket
$app->delete('/api/ticket/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM ticket WHERE ID = $id";

    try{
        $db = new db();

        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Ticket gelöscht"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

    
// GET einzelnes Ticket
$app->get('/api/ticket/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM ticket WHERE ID = $id";

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


// GET einzelnes Ticket mit Param
$app->get('/api/ticket', function(Request $request, Response $response){
    $id = $request->getParam('id');
    $sql = "SELECT * FROM ticket WHERE ID = $id";

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


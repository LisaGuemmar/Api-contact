<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/contact.php';

$database = new Database();
$db = $database->getConnection();
 
$contact = new contact($db);

$contact->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $contact->read();

if($result->num_rows > 0){    
    $contactRecords=array();
    $contactRecords["contact"]=array(); 
	while ($contact = $result->fetch_assoc()) { 	
        extract($contact); 
        $contactDetails=array(
            "id" => $id,
            "nom" => $nom,
            "prenom" => $prenom,
			"adresse" => $adresse,
            "telephone" => $telephone,            
			"age" => $age,
            "email" => $email			
        ); 
       array_push($contactRecords["contact"], $contactDetails);
    }    
    http_response_code(200);     
    echo json_encode($contactRecords);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No contact found.")
    );
} 
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/Database.php';
include_once '../class/contact.php';
 
$database = new Database();
$db = $database->getConnection();
 
$contact = new contact($db);
 
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->nom) && !empty($data->prenom) &&
!empty($data->adresse) && !empty($data->telephone) 
 && !empty($data->email) &&
!empty($data->age)){    

    $contact->nom = $data->nom;
    $contact->prenon = $data->description;
    $contact->email = $data->email;
    $contact->adresse = $data->adresse;
    $contact->telephone = $data->telephone;	
    $contact->age = $data->age; 
    
    if($contact->create()){         
        http_response_code(201);         
        echo json_encode(array("message" => "contact was created."));
    } else{         
        http_response_code(503);        
        echo json_encode(array("message" => "Unable to create contact."));
    }
}else{    
    http_response_code(400);    
    echo json_encode(array("message" => "Unable to create contact. Data is incomplete."));
}
?>
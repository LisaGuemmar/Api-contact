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

if(!empty($data->id) && !empty($data->nom) && !empty($data->email) && 
!empty($data->prenom) && !empty($data->adresse) 
&& !empty($data->age) && 
!empty($data->telephone)){ 
	
	$contact->id = $data->id; 
	$contact->nom = $data->nom;
    $contact->prenom = $data->prenom;
    $contact->email = $data->email;
	$contact->adresse = $data->adresse;
    $contact->telephone = $data->telephone;	
    $contact->age = $data->age;; 
	
	
	if($contact->update()){     
		http_response_code(200);   
		echo json_encode(array("message" => "contact was updated."));
	}else{    
		http_response_code(503);     
		echo json_encode(array("message" => "Unable to update contact."));
	}
	
} else {
	http_response_code(400);    
    echo json_encode(array("message" => "Unable to update contact. Data is incomplete."));
}
?>
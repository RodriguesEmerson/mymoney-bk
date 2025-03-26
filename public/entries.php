<?php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);

   header('Content-Type: application/json; charset=UTF-8');
   require_once __DIR__ . '/../src/Auth/tokenAuth.php';
   require_once __DIR__ . '/../src/Controlers/entriesControler.php';
   
   $headers = apache_request_headers();
   $tokenAuth = new TokenAuth();

   $headerToken = str_replace('Bearer ', '', $headers['Authorization']) ?? null; //Remove 'Beare ';
   if(empty($headerToken)){$headerToken = null;} //Ensures never pass the token empty in headers if it exist.
   $cookieToken = $_COOKIE['JWTToken'] ?? null;
   $token = $headerToken ?? $cookieToken;

   $userData = $tokenAuth->verifyToken($token);
   if(!$userData){ // 🔒 Protegendo a rota
      http_response_code(401);
      header('Content-Type: application/json');
      echo json_encode(["message" => "User not logged or invalid credentials"]);
      exit;
   }

   $request = str_replace('/mymoney-bk/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
   $method = $_SERVER['REQUEST_METHOD'];

   $entriesControler = new EntriesControler();
   $user = (array) $userData;

   if($request == '/entries.php'){
      switch($method){
         case 'GET':
            $entriesControler->listEntries($user['userId']);
         break;
         case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $entriesControler->setEntryController($data['description'], $data['category'], $data['date'], $data['value'], $user['userId']);
         break;
         case 'UPDATE':
            $data = json_decode(file_get_contents('php://input'), true);
            $entriesControler->updateEntryController($data);
         break;
      }
   }
?>
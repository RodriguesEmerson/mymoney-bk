<?php

   ini_set('display_errors', 1);
   error_reporting(E_ALL);

   header('Content-Type: application/json; charset=UTF-8');
   // header("Access-Control-Allow-Origin: *"); // Permite qualquer origem
   // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
   // header("Access-Control-Allow-Headers: Content-Type, Authorization");

   require_once __DIR__ . '/../src/Auth/tokenAuth.php';
   require_once __DIR__ . '/../src/Controlers/entriesControler.php';
   
   $tokenAuth = new TokenAuth();
   if(!$tokenAuth->verifyToken()){
      http_response_code(401);
      header('Content-Type: application/json');
      echo json_encode(["message" => "User not logged or invalid credentials"]);
      exit;
   }
   
   $request = str_replace('/mymoney-bk/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
   $method = $_SERVER['REQUEST_METHOD'];
   
   $userData = $tokenAuth->verifyToken(); // 🔒 Protegendo a rota
   $user = (array) $userData;

   if($request == '/entries.php' && $method == 'GET'){
      $EntriesControler = new EntriesControler();
      $EntriesControler->listEntries($user['userId']);
   }
?>
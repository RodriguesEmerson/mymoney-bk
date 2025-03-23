<?php 
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   
   header('Content-Type: application/json; charset=UTF-8');
   // header("Access-Control-Allow-Origin: *"); // Permite qualquer origem
   // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
   // header("Access-Control-Allow-Headers: Content-Type, Authorization");
   
   require_once __DIR__ . '/../src/Auth/signupAuth.php';
   $signupAuth = new SignupAuth();
   
   $request = str_replace('/mymoney-bk/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
   $method = $_SERVER['REQUEST_METHOD'];


   if($request == '/signup.php' && $method == 'POST'){
      $data = json_decode(file_get_contents('php://input'), true);
      $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

      ///.....Here still needs to validate the entries data.
      $signupAuth->createUser($data['name'], $data['lastname'], $data['email'], $hashedPassword);
      exit;
   }
?>
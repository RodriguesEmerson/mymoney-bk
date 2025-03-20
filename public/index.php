<?php 
   ini_set('display_errors', 1);
   error_reporting(E_ALL);

   
   header("Content-Type: application/json");
   
   require_once __DIR__ . '/../src/Controlers/authController.php';
   require_once __DIR__ . '/../src/Controlers/newUserController.php';
   header('Content-Type: application/json');  
   
   $authController = new AuthController();
   $newUserController = new NewUserController();
   $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   var_dump($request, $method);
   var_dump($_POST);

   /**
    * Login
    */

   if($request == '/login' && $method == 'POST'){
      $data = json_decode(file_get_contents('php://input'), true);
      ///.....Here still needs to validate the entries data.
      $authController->login($data['email'], $data['password']);
   }elseif($request == '/verify-token' && $method == 'GET'){
      $authController->verifyToken();
   }else{
      http_response_code(404);
      echo json_encode(['error' => 'Rout not found']);
   };

   /**
    * Create user
    */
    if($request == '/signup' && $method == 'POST'){
      var_dump('HERE');
      $data = json_decode(file_get_contents('php://input'), true);
      $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
      ///.....Here still needs to validate the entries data.
      $newUserController->createUser($data['name'], $data['lastname'], $data['email'], $hashedPassword);

    }

?>
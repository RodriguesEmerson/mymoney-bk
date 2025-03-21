<?php 
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   
   
   header('Content-Type: application/json; charset=UTF-8');
   
   require_once __DIR__ . '/../src/Controlers/authController.php';
   require_once __DIR__ . '/../src/Controlers/newUserController.php';
   
   $authController = new AuthController();
   $newUserController = new NewUserController();
   echo json_encode(['m' =>'ETE']);
   exit();
   $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];
   
   if($request === 'a'){

   }else{
   }
   exit;
   /**
    * Login
    */
   if($request == '/login' && $method == 'POST'){
      $data = json_decode(file_get_contents('php://input'), true);
      if (!$data) {
         echo json_encode(['error' => 'Invalid JSON']);
         http_response_code(400);
         exit;
     }
      ///.....Here still needs to validate the entries data.
      $authController->login($data['email'], $data['password']);
     exit;

   }elseif($request == '/signup' && $method == 'POST'){
      $data = json_decode(file_get_contents('php://input'), true);
      $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
      ///.....Here still needs to validate the entries data.
      $newUserController->createUser($data['name'], $data['lastname'], $data['email'], $hashedPassword);
      exit;


   }elseif($request == '/verify-token' && $method == 'GET'){
      $authController->verifyToken();
      exit;

   }else{
      http_response_code(404);
      echo json_encode(['error' => 'Rout not found']);
   };

   /**
    * Create user
    */
  

?>
<?php 
  
   require_once __DIR__ . '/../Models/user.php';
   require_once __DIR__ . '/../Helpers/JWT.php';

   class SigninAuth{
      private $userModel;
      public function __construct(){
         $this->userModel = new User();
      }

      public function signin(string $email, string $password){
         $user = $this->userModel->getByEmail($email);

         if($user && password_verify($password, $user['password'])){
            $token = JWTHandler::generateToken($user['id'], $user['name'], $user['email']);

            setcookie('JWTToken', $token, [
               'expires' => time() + 3600,  //It expires in 1 hour
               'path' => '/',               //Avalaible for the entire site
               'httponly' => true,          //It protects against accesses by javascript
               'secure' => true,            //Only HTTPS
               'samesite' => 'Strict'       //Avoid other sites accsses
            ]);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(["message" => 'Authenticated successfuly']);
         }

         if(!isset($user)){
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(["error" => "Invalid credentials"]);
            exit;
         }
      }
   }
?>
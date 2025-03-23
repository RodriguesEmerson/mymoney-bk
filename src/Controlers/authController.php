<?php
require_once __DIR__ . '/../Models/user.php';
require_once __DIR__ . '/../Helpers/JWT.php';

class AuthController{
   private $userModel;

   public function __construct(){
      $this->userModel = new User();
   }


   public function login(string $email, string $password){
      $user = $this->userModel->getByEmail($email);

      if ($user && password_verify($password, $user['password'])) {
         $token = JWTHandler::generateToken($user['id'], $user['name'], $user['email']);

         setcookie('jwt', $token, [
            'expires' => time() + 3600,  //It xxpires in 1 hour
            'path' => '/',               //Avalaible for the entire site
            'httponly' => true,          //It protects against accesses by javascript
            'secure' => true,            //Only HTTPS
            'samesite' => 'Strict'       //Avoid other sites accsses
         ]);

         echo json_encode(["message" => 'Authenticated successfuly']);
      } else {
         http_response_code(401);
         echo json_encode(["error" => "Invalid credentials"]);
      }
   }  

   public function verifyToken(){
      $token = $_COOKIE['jwt'] ?? null;
      if (!isset($token)){
         http_response_code(401);
         echo json_encode(["error" => "Token missing"]);
         return false;
         exit;
      }

      $userData = JWTHandler::validateToken($token);

      if (!$userData) {
         http_response_code(403);
         echo json_encode(["message" => "Invalid or expired token"]);
         return false;
         exit;
      } 

      return $userData;
   }
}

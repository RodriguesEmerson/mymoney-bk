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
         $token = JWTHandler::generateToken($user['id']);
         echo json_encode(["token" => $token]);
      } else {
         http_response_code(401);
         echo json_encode(["error" => "Invalid credentials"]);
      }
   }  

   public function verifyToken(){
      $headers = getallheaders();
      if (!isset($headers['Authorization'])){
         http_response_code(401);
         echo json_encode(["error" => "Token missing"]);
         return;
      }

      $token = str_replace("Bearer ", "", $headers['Authorization']);
      $decoded = JWTHandler::validateToken($token);

      if ($decoded) {
         http_response_code(200);
         echo json_encode(["message" => "Access granted", "user_id" => $decoded->user_id]);
      } else {
         http_response_code(401);
         echo json_encode(["error" => "Invalid token"]);
      }
   }
}

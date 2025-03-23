<?php 
   require_once __DIR__ . '/../Models/user.php';
   require_once __DIR__ . '/../Helpers/JWT.php';

   class TokenAuth{
      
      private $token;
      public function __construct(){
         $this->token =  $_COOKIE['JWTToken'] ?? null;
      }

      public function verifyToken(){
         if (!isset($this->token)){
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(["error" => "Token missing"]);
            return false;
            exit;
         }
   
         $userData = JWTHandler::validateToken($this->token);
         if (!$userData) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(["message" => "Invalid or expired token"]);
            return false;
            exit;
         } 
   
         return $userData;
      }

   }

?>
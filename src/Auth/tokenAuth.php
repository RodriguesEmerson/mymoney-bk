<?php 
   require_once __DIR__ . '/../Models/user.php';
   require_once __DIR__ . '/../Helpers/JWT.php';
   $headers = apache_request_headers();

   class TokenAuth{
      
      private $token;
      public function __construct(){
         $this->token =  $_COOKIE['JWTToken'] ?? null; //Via js;
         $this->token =  $_COOKIE['JWTToken'] ?? null; //Via PHP
      }

      public function verifyToken(string $token){
         if (!isset($token)){
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(["error" => "Token missing"]);
            return false;
            exit;
         }

         $userData = JWTHandler::validateToken($token);

         if ($userData === null) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(["message" => "Invalid or expired token"]);
            return false;
         } 
         // echo json_encode($userData);exit;
         
         return $userData;
      }
   }

?>
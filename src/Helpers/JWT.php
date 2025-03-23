<?php 
   require_once __DIR__ . '/../../vendor/autoload.php';
   require_once __DIR__ . '/../../config/config.php';
   use Firebase\JWT\JWT;
   use Firebase\JWT\key;

   class JWTHandler{
      private static $secret_key;

      /**
       * Generete a JWT token
       */
      public static function generateToken($userId, $userName, $userEmail){
         self::$secret_key = getenv('JWT_SECRET_KEY');
         $payload = [
            'iss' => 'localhost',
            'iat' => time(),
            'exp' => time() + (60 * 60), //Token expires in 1 hour
            'userId' => $userId,
            'userName' => $userName,
            'userEmail' => $userEmail
         ];
         return JWT::encode($payload, self::$secret_key, 'HS256');
      }
      
      /**
       * Validate the current token
       */
      public static function validateToken($token){
         try{
            self::$secret_key = getenv('JWT_SECRET_KEY');
            return JWT::decode($token, new key(self::$secret_key, 'HS256'));
         }catch(Exception $e){
            return false;
         }
      }
   }

?>
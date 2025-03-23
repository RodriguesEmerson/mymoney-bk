<?php
     
   require __DIR__ . '/config.php';

   class Database{
      private static $pdo; //It keeps the connection;

      public static function getConnection(){
    
         if(!self::$pdo){ // Check if has a connection.

            $db = getenv('DB_NAME');
            $host = getenv('DB_HOST');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASS');

            try{
               self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", "$user", "$password");
               self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
               
            }catch(PDOException $e){
               echo json_encode(['massage' => 'It was not possible connecting to the database.']);
               die();
            }
         }
         return self::$pdo;
      }
   }

   

?>
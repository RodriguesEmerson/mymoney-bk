<?php
   require __DIR__ . '/config.php';

   class Database{
      private static $pdo; //It keeps the connection;

      public static function getConnection(){
         if(!self::$pdo){ // Verifica se já existe uma conexão

            $db = getenv('DB_NAME');
            $host = getenv('DB_HOST');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASS');

            try{
               self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", "$user", "$password");
               self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
               
               var_dump(self::$pdo);
            }catch(PDOException $e){
               echo 'Não foi possível conectar ao banco de dados.';
               die();
            }
         }
         return self::$pdo;
      }
   }

   

?>
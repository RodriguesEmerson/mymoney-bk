<?php
   require __DIR__ . '/config.php';

   $db = getenv('DB_NAME');
   $host = getenv('DB_HOST');
   $user = getenv('DB_USER');
   $password = getenv('DB_PASS');
   
   try{
      $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", "$user", "$password", [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      var_dump($pdo);
   }catch(PDOException $e){
      echo 'Não foi possível conectar ao banco de dados.';
      die();
   }

?>
<?php 
      require_once __DIR__ . '/../../config/database.php';
   class User{
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
      }

      //Fetch users by email
      public function getByEmail(string $email):array{
         $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE email = :email');
         $stmt->bindValue(':email', $email);
         $stmt->execute();
         return $stmt->fetch(PDO::FETCH_ASSOC);
      }
   }
?>
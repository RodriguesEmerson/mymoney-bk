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

      public function createNewUser(string $name, string $lastname, string $email, string $password):bool{
         try{
            $stmt = $this->pdo->prepare('INSERT INTO `users` (`name`, `lastname`, `email`, `password`) 
                                         VALUES (:name, :lastname, :email, :password) ');
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':lastname', $lastname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
            return true;
            
         }catch(Exception $e){
            return false;
         }
      }
   }
?>
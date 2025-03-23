<?php 
   require_once __DIR__ . '/../../config/database.php';
   
   class NewUser{
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
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
            // http_response_code(401);
            // echo json_encode(['error' => 'It was not possible creating new user.']);
            return false;
         }
      }
   
   }
?>
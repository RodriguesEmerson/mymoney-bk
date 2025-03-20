<?php 
   require_once __DIR__ . '/../../config/database.php';

   class Entries {
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
      }

      //
      public function getEntries(){
         $stmt = $this->pdo->prepare('SELECT `id`, `description`, `category`, `date`, `value`, `foreing_key` FROM `entries` ORDER BY `date` DESC LIMIT 10');
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

         return $result;
      }
   }
?>
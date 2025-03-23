<?php 
   require_once __DIR__ . '/../../config/database.php';

   class Entries {
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
      }

      public function getEntries(string $userId, int $limit){
         try{
            $stmt = $this->pdo->prepare('SELECT `id`, `description`, `category`, `date`, `value`, `foreing_key` 
                                         FROM `entries` WHERE `foreing_key` = :foreingKey ORDER BY `date` DESC LIMIT :limit');
            $stmt->bindValue(':foreingKey', $userId);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;

         }catch(Exception $e){
            return false;
         }
      }
   }
?>
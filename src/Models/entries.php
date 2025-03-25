<?php 
   require_once __DIR__ . '/../../config/database.php';

   class Entries {
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
      }

      public function getEntries(string $userId, int $limit):bool|array{
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

      public function getCategories():bool|array{
         try{
            $stmt = $this->pdo->prepare('SELECT `categories` FROM `categories`');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
         }catch(Exception $e){
            return false;
         }
      }

      public function setEntry(string $description, string $category, string $date, float $value, int $userId):bool{
         try{
            $stmt = $this->pdo->prepare('INSERT INTO `entries` (`description`, `category`, `date`, `value`, `foreing_key`) 
                                         VALUES (:description, :category, :date, :value, :foreing_key)');
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':category', $category);
            $stmt->bindValue(':date', $date);
            $stmt->bindValue(':value', $value);
            $stmt->bindValue(':foreing_key', $userId);

            $stmt->execute();
            return true;
         }catch(Exception $e){
            return false;
         }
      }

      public function updateEntry($data){
         //CRIAR FUNÇÃO PARA INSERIR DADOS NO DB
      }
   }
?>
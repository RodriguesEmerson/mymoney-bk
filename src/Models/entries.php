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
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
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

         if(!isset($data['id']) || empty($data['id'])){
            throw new Exception('Missing Id');
         }

         $query = [];
         $params = [];
         
         foreach ($data AS $column => $value) {
            if($column == 'id') continue;
            $query[] = "`$column` = :$column"; //Avoid SQL Injection
            $params[":$column"] = $value;
         }

         if(empty($query)){
            throw new Exception('There is no any data to update');
         }

         $setQuery = implode(",", $query);
         $sql = "UPDATE `entries` SET $setQuery WHERE `id` = :id ";
         $params[':id'] = $data['id'];
         
         // echo json_decode($sql);exit;

         $stmt = $this->pdo->prepare($sql);
         if(!$stmt->execute($params)){
            throw new Exception('Internal server error');
            exit;
         };
         return true;
      }
   }
?>
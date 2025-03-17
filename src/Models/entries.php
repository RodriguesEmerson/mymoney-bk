<?php 
   // class entries{
   //    public function __construct(
   //       public int $id,
   //       public string $description,
   //       public string $category,
   //       public string $date,
   //       public float $value,
   //       public int $foreing_key,
   //    ){}
   // }

   require __DIR__ . '/../../config/database.php';

   class User {
      private $pdo;
      public function __construct(){
         $this->pdo = Database::getConnection();
      }

      //
      public function getEntries(){
         $stmt = $this->pdo->prepare();
      }

   }

?>
<?php 
   require_once __DIR__ . '/../Models/entries.php';

   class EntriesControler{
      private $EntrieModel;
      public function __construct(){
         $this->EntrieModel = new Entries();
      }

      /**
       * Return a list with the data;
       */
      public function listEntries(string $userId){

         $data = $this->EntrieModel->getEntries($userId, 10);

         if($data){
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Data fetched successfuly', 'data' => $data]);
            exit;
         }
   
         http_response_code(500);
         header('Content-Type: application/json');
         echo json_encode(['message' => 'Internal sever error']);
      }

      /**
       * Insert new entries into the database.
       */
      public function setEntryController(string $description, string $category, string $date, float $value, int $userId){
         if($this->EntrieModel->setEntry($description, $category, $date, $value, $userId)){
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Entry saved successfuly']);
            exit;
         }

         http_response_code(500);
         header('Content-Type: application/json');
         echo json_encode(['message' => 'Internal server error']);
      }

      public function updateEntryController(){
         
      }
   }
?>
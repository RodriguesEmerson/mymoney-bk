<?php 
   require_once __DIR__ . '/../Models/entries.php';
   require_once __DIR__ . '/../Helpers/validators.php';

   class EntriesControler{
      private $EntrieModel;
      private $validators;
      public function __construct(){
         $this->EntrieModel = new Entries();
         $this->validators = new Validators;
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

      public function updateEntryController($data){
        
         foreach($data AS $item => $value){
            switch($item) {
               case 'date':
                  if(!$this->validators->validateDate($value)){
                     http_response_code(400); //Bad request
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'Invalid Date']);
                     exit;
                  };
               break;
               case 'description':
                  if(!$this->validators->validateString($value)){
                     http_response_code(400);
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'Invalid Description']);
                     exit;
                  }
               break;   
               case 'value':
                  if(!$this->validators->validateValue($value)){
                     http_response_code(400);
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'Invalid Value']);
                     exit;
                  }
               break;
               case 'category':
                  $categories = $this->EntrieModel->getCategories();
                  if(!$categories){
                     http_response_code(500);
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'Internal server error']);
                     exit;
                  }

                  if(!$this->validators->validateString($value)){
                     http_response_code(400);
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'Invalid Category']);
                     exit;
                  }
                  if(!in_array($value, $categories)){
                     http_response_code(400);
                     header('Content-Type: application/json');
                     echo json_encode(['message' => 'The Category does not exist']);
                     exit;
                  }
               break;
            }
         }

         try{
            $this->EntrieModel->updateEntry($data);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Entry updated']);
            exit;
         }catch(Exception $e){
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Internal server error']);
            exit;
         }

      }
   }
?>
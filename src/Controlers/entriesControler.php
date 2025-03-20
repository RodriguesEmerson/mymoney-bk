<?php 
   require_once __DIR__ . '/../Models/entries.php';

   class EntriesControler{
      private $EntrieModel;
      public function __construct(){
         $this->EntrieModel = new Entries();
      }

      public function listEntries(){
         $entries = $this->EntrieModel->getEntries();
         header('Content-Type: application/json');
         echo json_encode($entries);
      }
   }
?>
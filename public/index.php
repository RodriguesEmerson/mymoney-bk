<?php 
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   
   require_once __DIR__ . '/../src/Controlers/entriesControler.php';
   $entriesController = new EntriesControler();
   $entriesController->listEntries();

?>
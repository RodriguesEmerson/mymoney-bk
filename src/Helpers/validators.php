<?php 

   class Validators{

      public function validateDate($value):bool{
         if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return false;
         }
         return true;
      }

      public function validateString(string $value):bool{
         if(strlen($value) > 255 || strlen($value) == 0){
            return false;
         }
         return true;
      }
      
      public function validateValue($value){
         if(!is_numeric($value)){
            return false;
         }
         return true;
      }
   }

?>
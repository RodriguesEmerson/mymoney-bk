<?php 

   class Validators{

      public function validateDate($value):bool{
         if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return false;
         }
         return true;
      }

      public function validateString($value):bool{
         if(count_chars($value) > 255 || count_chars($value == 0)){
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
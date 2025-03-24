<?php 
   require_once __DIR__ . '/../Models/user.php';

   class SignupAuth{
      private $userModel;
      
      public function __construct(){
         $this->userModel = new User();
      }
      
      public function createUser(string $name, string $lastname, string $email, string $password){
         
         if (!empty($name) && !empty($lastname) && !empty($email) && !empty($password)){
            if($this->userModel->createNewUser($name, $lastname, $email, $password)){
               http_response_code(201); //Successful Creation status code;
               header('Content-Type: application/json');
               echo json_encode(['message' => 'New user created.']);
            }else{
               http_response_code(500); //Internal server error
               header('Content-Type: application/json');
               echo json_encode(['message' => 'Erro creating user.']);               
            }

         }else{
            http_response_code(400); //Invalid request
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Missing required fields.']); 
         }
      }

   }
?>
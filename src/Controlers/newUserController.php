<?php 
   require_once __DIR__ . '/../Models/newUser.php';
   
   class NewUserController{
      private $newUser;
      
      public function __construct(){
         $this->newUser = new NewUser();
      }
      
      public function createUser(string $name, string $lastname, string $email, string $password){
         
         if (!empty($name) && !empty($lastname) && !empty($email) && !empty($password)){
            if($this->newUser->createNewUser($name, $lastname, $email, $password)){
               http_response_code(201); //Successful Creation status code;
               echo json_encode(['message' => 'New user created.']);
               header('Location: ./../../novouser.php');
            }else{
               http_response_code(500); //Internal server error
               echo json_encode(['message' => 'Erro creating user.']);               
            }

         }else{
            http_response_code(400); //Invalid request
            echo json_encode(['message' => 'Missing required fields.']); 
         }
      }

   }
?>
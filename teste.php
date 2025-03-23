<?php 
   require_once __DIR__ . '/src/Controlers/authController.php';
   $authController = new AuthController();
   $userData = $authController->verifyToken(); // 🔒 Protegendo a rota
   $user = (array) $userData;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <p>Ola: <?php echo $user['userName']?></p>
   <p>Email: <?php echo $user['userEmail']?></p>
</body>
</html>
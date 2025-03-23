<?php 
   require_once __DIR__ . '/src/Auth/tokenAuth.php';
   $tokenAuth = new TokenAuth();
   $userData = $tokenAuth->verifyToken(); // 🔒 Protegendo a rota
   $user = (array) $userData;

   require_once __DIR__ . '/src/Controlers/entriesControler.php';
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

   <div id="entries"></div>

   <script>
      const entriesDiv = document.querySelector('#entries');

      window.addEventListener('load', req);

      async function req(){
         const data = await fetch('http://localhost/mymoney-bk/public/entries.php',{
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
         });
         const response = await data.json();
         console.log(response)
      }

   </script>
</body>
</html>
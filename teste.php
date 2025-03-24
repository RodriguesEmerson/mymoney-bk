<?php 
   require_once __DIR__ . '/src/Auth/tokenAuth.php';
   $tokenAuth = new TokenAuth();
   $token = $_COOKIE['JWTToken'] ?? null;

   $userData = $tokenAuth->verifyToken($token); //🔒 Protegendo a rota; //If the requisition were made with js, it doesn't need to pass token.
   $user = (array) $userData;
   
   require_once __DIR__ . '/src/Controlers/entriesControler.php';
      $token = $_COOKIE['JWTToken'] ?? null;
      $options = [
         'http' => [
            'method' => 'GET',
            'header' => 
               "Content-Type: application/json\r\n" . 
               "Authorization: Bearer $token\r\n",
            'timeout' => 10,
         ]
      ];
      $context = stream_context_create($options);
      $data = file_get_contents('http://localhost/mymoney-bk/public/entries.php', false, $context);

      // var_dump($data);
      $entries = json_decode($data, true)['data'];
      // var_dump($entries);

   function e($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
   }

?>
<!DOCTYPE html>
<html lang="pt">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
   <p>Ola: <?php echo $user['userName']?></p>
   <p>Email: <?php echo $user['userEmail']?></p>

   <form id="formID" >
      <input type="text" name="description" placeholder="Description" value="Test-1">
      <input type="text" name="category" placeholder="Category" value="Category-1">
      <input type="text" name="date" placeholder="Date" value="24-03-2025">
      <input type="text" name="value" placeholder="Value" value="3.52">
      <input type="submit" value="SignUp">
   </form>


   <div id="entries">
      <table>
         <thead>
            <tr>
               <th>Description</th>
               <th>Category</th>
               <th>Date</th>
               <th>Value</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($entries AS $entry):?>
               <tr>
                  <td><?php echo e($entry['description']) ?></td>
                  <td><?php echo e($entry['category']) ?></td>
                  <td><?php echo e($entry['date']) ?></td>
                  <td><?php echo e($entry['value']) ?></td>
               </tr>
            <?php endforeach;?>
         </tbody>
      </table>
   </div>

    <script>
      const form = document.querySelector('#formID');
      form.addEventListener('submit', req);
      async function req(e){
         e.preventDefault();
         const formdata = new FormData(form);
         const data = Object.fromEntries(formdata.entries());

         const request = await fetch('http://localhost/mymoney-bk/public/entries.php',{
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'Authorization': ``},
            body: JSON.stringify(data)
         });
         const response = await request.json();
         console.log(response);
      }

   </script>
</body>
</html>
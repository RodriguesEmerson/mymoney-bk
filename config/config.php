<?php 
   function loadEnv($file = __DIR__ . '/../.env'){
      if (!file_exists($file)) {
         die("Erro: Arquivo .env não encontrado! Caminho: " . realpath($file));
      }

      $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($lines as $line) {
         if (strpos(trim($line), '#') === 0) continue; // Ignora comentários

         list($key, $value) = explode('=', $line, 2);
         putenv("$key=$value");
         $_ENV[$key] = $value;
         $_SERVER[$key] = $value;
      }
   }
   loadEnv();

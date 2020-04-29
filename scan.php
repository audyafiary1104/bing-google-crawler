<?php
 require 'Vendor/function.php';
 $line = readline("Select FILE DORK: ");
   if (file_exists($line)) {
    echo "COUNT DORK".PHP_EOL;
    $pecah = explode(PHP_EOL,file_get_contents($line));
    echo "DORK TOTALS => ".count($pecah).PHP_EOL;
    foreach ($pecah as $key => $value) {
        Eksekusi($value);
    }
}else{
       exit;
   } 
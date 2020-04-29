<?php
require 'Bing.php';
require 'Google.php';

function Eksekusi($dork)
{
   $google = new Google();
   $bing = new Bing();
   echo "FETCH GOOGLE => " .$dork.PHP_EOL;
   $google->search($dork);
   echo "DONE FETCH GOOGLE => " .$dork.PHP_EOL;

   echo "FETCH BING => " .$dork.PHP_EOL;
   $bing->bings($dork);
   echo "DONE FETCH BING => " .$dork.PHP_EOL;


}
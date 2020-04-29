<?php

class Bing
{
   public function bings($dork)
    {
        for ($i=1; $i < 2 ; $i++) { 
            $url = "http://www.bing.com/search?q=".urlencode($dork)."&go=&filt=all&first={$i}";
           $this->get($url);
        }
    }
    public function get($uri){
        $ch  = curl_init();
        curl_setopt_array($ch, [
             CURLOPT_URL            => $uri,
             CURLOPT_RETURNTRANSFER => TRUE,
             CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:23.0) Gecko/20100101 Firefox/23.0',
             CURLOPT_HTTPHEADER     => ['Expect:', 'Connection: close', 'Content-type: application/x-www-form-urlencoded'],
             CURLOPT_CONNECTTIMEOUT => 10
        ]);
  
        $http_response = curl_exec($ch);
        $http_info     = curl_getinfo($ch);
        curl_close($ch);
        preg_match_all("#href=\"(.*?)\">#",$http_response, $matches);
        foreach($matches[1] as $keys => $uri):
          if($uri && strstr($uri, 'http://') && !preg_match('/msn|microsoft|php-brasil|facebook|4shared|bing|imasters|
                                  phpbrasil|php.net|yahoo|scriptbrasil|under-linux/', $uri) && !in_array($uri, [])):
                                  echo "Bing => ".$keys.' / '. count($matches[1]).PHP_EOL;

              file_put_contents('result/result-'.date('Y-m-d').'.txt'  ,strstr($uri, '"', true) . PHP_EOL, FILE_APPEND);
          endif;
      endforeach;
    }    
}

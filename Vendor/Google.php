<?php
 class Google 
 {
     
    function getToken(){
        $groups = [];
        $base_url = "https://cse.google.com/cse.js?cx=partner-pub-2698861478625135:3033704849";
        preg_match_all("/cse_token\":.*?\"(.*?)\"/mi", file_get_contents($base_url), $matches, PREG_SET_ORDER, 0);
        
        if(empty($matches)){
            echo "Err...";exit();
        }
        $full = $matches;
                
        for($i = 0; $i<count($matches); $i++){
            if(!empty($matches[$i][1])) array_push($groups,$matches[$i][1]);
        }
                
        return array($full,$groups);
    }
    function ambilKata($param, $kata1, $kata2){
        if(strpos($param, $kata1) === FALSE) return FALSE;
        if(strpos($param, $kata2) === FALSE) return FALSE;
        $start = strpos($param, $kata1) + strlen($kata1);
        $end = strrpos($param, $kata2, $start);
        $return = substr($param, $start, $end - $start);
        return $return;
    }
    function search($query)
    {
        $settings = array(
            "allPagesOutput" => true, // true | false (if false, will only show the first page results)
            "showTitle" => true, // true | false
            "showUrl" => true, // true | false
            "showUrlType" => "url", //formattedUrl | unescapedUrl | visibleUrl | url
            "showDesc" => true, // true | false
            "showThumbnailUrl" => false, // true | false
            "onScreenOutput" => false // true | false (if true, the result will show up on your screen)
        );
        $pages = [];
        $results = [];
    
        $cseToken = $this->getToken();
    
        $base_url = "https://cse.google.com/cse/element/v1?num=10&hl=en&cx=partner-pub-2698861478625135:3033704849&safe=off&cse_tok=".$cseToken[1][0]."&start={page_no}&q={query}&callback=x";
        $temporary_url = str_replace("{query}",urlencode($query),$base_url);
        $get = file_get_contents(str_replace("{page_no}","0",$temporary_url));
        $clearCB = $this->ambilKata($get, "x(",');');
        $res = json_decode($clearCB);
    
        for($i = 0; $i<count($res->cursor->pages); $i++){
            array_push($pages,$res->cursor->pages[$i]->start);
        }
        for($i = 0; $i<count($pages); $i++){
            $clearCB = $this->ambilKata(file_get_contents(str_replace("{page_no}",$pages[$i],$temporary_url)), "x(",');');
            $res = json_decode($clearCB);
            if (isset($res->results)) {
                echo "GOOGLE => ".$i.' / '. count($res->results).PHP_EOL;
                for($iix = 0; $iix<count($res->results); $iix++){
                    file_put_contents('result/result-'.date('Y-m-d').'.txt' ,$res->results[$iix]->url. PHP_EOL, FILE_APPEND);
                }
           }
          
        }
    }
 }
 
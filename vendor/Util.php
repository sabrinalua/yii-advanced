<?php

namespace vendor;

class Util {
	/*
	declare public attributes here
	*/
	
	//checks if an url is valid
	public function visit($url){
		// $url="http://www.aluxurytravelblog.com/feed/";
		$agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
		$ch=curl_init();
		curl_setopt ($ch, CURLOPT_URL,$url );
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch,CURLOPT_VERBOSE,false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch,CURLOPT_SSLVERSION,3);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
		$page=curl_exec($ch);
       //echo curl_error($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       
       if($httpcode>=200 && $httpcode<300) {
       	curl_close($ch);
       	return true;
       }
       else {
       curl_close($ch);
       	return false;
       }
	}
}

?>
<?php

namespace vendor;

use vendor\simple_html_dom;
use vendor\OpenGraph;

// Yii::import('ext.simple_html_dom');
// Yii::import('ext.OpenGraph');

/*
 ======================================================================
 lastRSS 0.9.1
 
 Simple yet powerfull PHP class to parse RSS files.
 
 by Vojtech Semecky, webmaster @ webdot . cz
 
 Latest version, features, manual and examples:
 	http://lastrss.webdot.cz/

 ----------------------------------------------------------------------
 LICENSE

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License (GPL)
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 To read the license please visit http://www.gnu.org/copyleft/gpl.html
 ======================================================================
*/

/**
* lastRSS
* Simple yet powerfull PHP class to parse RSS files.
*/
class RssAtomParser {
	// -------------------------------------------------------------------
	// Public properties
	// -------------------------------------------------------------------

	var $default_cp = 'UTF-8';
	var $CDATA = 'nochange';
	var $cp = '';
	var $items_limit = 0;
	var $stripHTML = False;
	var $date_format = '';


	// -------------------------------------------------------------------
	// Private variables
	// -------------------------------------------------------------------
	// var $channeltags = array ('title', 'link', 'description', 'language', 'copyright', 'managingEditor', 'webMaster', 'lastBuildDate', 'rating', 'docs');
	var $channeltags = array ('title', 'link', 'description');
	var $channeltags2 = array ('title');

	var $itemtags = array('title', 'link', 'description', 'author', 'category', 'enclosure', 'guid', 'pubDate', 'source','content');
	var $textinputtags = array('title', 'description', 'name', 'link');

	var $feedTags = array('title', 'id', 'updated', 'author', 'link', 'category', 'contributor','generator', 'icon', 'logo','rights', 'subtitle');
	var $feedTags2 = array ('title');
	var $authorTag = array('name','uri', 'email');
	var $entryTags = array('title', 'id', 'updated', 'author', 'content','link', 'summary', 'category','contributor', 'published','rights','source');


	function exampleRssLoad($arr=null){
		$arrayz = array('http://www.malaysia-traveller.com/Malaysia-travel.xml',
		'http://trekkingwithtwins.com/feed/',);

		if($arr!=null){
			$arrayz=$arr;
		}		
		
		$count =0;
		//loop thru each url
		foreach ($arrayz as $arr){
			$feedSourceID = $arr['uid'];
			if($rs = $this->get($arr['link'])){				

				$root_type=$rs['type'];
				$root_author= "unknown";
				$root_title = $rs['title'];

				echo "rootTYPE!!=" .$root_type;
			}
		}
	}


	
	/*--------------------------------------------------------------
	get OG link of RSS feed
	uses OpenGraph.php courtesy of scottmac@github
	$url = http/https url
	----------------------------------------------------------------*/
	function getOG($url){
		$graph = OpenGraph::fetch($url);
		// var_dump($graph->keys());
		// var_dump($graph->schema);
		$array = array();
		foreach ($graph as $key => $value) {
			$array[$key] = $value;
		}

		return $array['image'];
	}
	/*--------------------------------------------------------------
	$type = "url" or "content"
	$content value passed in, either a link or a html string
	----------------------------------------------------------------*/
	function parseContent($type,$content){
		$html = new simple_html_dom();
		if ($type=="content") 
		{
			// $html = str_get_html($content);
			$html->load($content);
		}else if ($type=="url"){
			$html->load_file($content);
			// $html = file_get_html($content);
		}
		$array = array();
		foreach($html->find('img') as $element){

			array_push($array, $element->src);
			// echo $element->src. '<br>';
		}
		return $array;
	}


	// -------------------------------------------------------------------
	// Parse RSS file and returns associative array.
	// -------------------------------------------------------------------
	function Get ($rss_url) {
		// If CACHE ENABLED
		if ($this->cache_dir != '') {
			$cache_file = $this->cache_dir . 'cache_' . md5($rss_url);
			$timedif = @(time() - filemtime($cache_file));
			if ($timedif < $this->cache_time) {
				// cached file is fresh enough, return cached array
				$result = unserialize(join('', file($cache_file)));
				// set 'cached' to 1 only if cached file is correct
				if ($result) $result['cached'] = 1;
			} else {
				// cached file is too old, create new
				$result = $this->Parse($rss_url);
				$serialized = serialize($result);
				if ($f = @fopen($cache_file, 'w')) {
					fwrite ($f, $serialized, strlen($serialized));
					fclose($f);
				}
				if ($result) $result['cached'] = 0;
			}
		}
		// If CACHE DISABLED >> load and parse the file directly
		else {
			$result = $this->Parse($rss_url);
			if ($result) $result['cached'] = 0;
		}
		// return result
		return $result;
	}

	function getRootTitle($rss_url){
		$result= $this->Parse2($rss_url);
		return $result;
	}

	function Parse2($rss_url){
		$rsBool = true; //is RSS
		// Open and load RSS file
		if ($f = @fopen($rss_url, 'r')) {
			$rss_content = '';
			while (!feof($f)) {
				$rss_content .= fgets($f, 4096);
			}
			fclose($f);

		   if(preg_match("'<channel.*?>(.*?)</channel>'si", $rss_content, $out_channel)==false){
		   		preg_match("'<feed.*?>(.*?)</feed>'si", $rss_content, $out_channel);
		   		$rsBool=false;
		   }

		   if($rsBool){
		   		
			   	foreach($this->channeltags2 as $channeltag)
				{
					$temp = $this->my_preg_match("'<$channeltag.*?>(.*?)</$channeltag.*?>'si", $out_channel[1]);
					
					if ($temp != '') $result[$channeltag] = $temp; // Set only if not empty
				}
		   }else{
		   		
		   		foreach($this->feedTags2 as $feedTag)
				{
					/*if(!$temp = $this->my_preg_match("'<$feedTag.*?>(.*?)</$feedTag.*?>'si", $out_channel[1]))*/
					$temp = $this->my_preg_match("'<$feedTag.*?>(.*?)</$feedTag.*?>'si", $out_channel[1]);
						
					if ($temp != '') $result[$feedTag] = $temp; // Set only if not empty
				}
		   }
		}else{
			// Yii::log('Parse 2 Return false', 'error', 'system.*');
			return false;
		}

		return $result;
	}
	
	// -------------------------------------------------------------------
	// Modification of preg_match(); return trimed field with index 1
	// from 'classic' preg_match() array output
	// -------------------------------------------------------------------
	function my_preg_match ($pattern, $subject) {
		// start regullar expression
		preg_match($pattern, $subject, $out);
		var_dump($out);

		// if there is some result... process it and return it
		if(isset($out[1])) {
			// Process CDATA (if present)
			if ($this->CDATA == 'content') { // Get CDATA content (without CDATA tag)
				$out[1] = strtr($out[1], array('<![CDATA['=>'', ']]>'=>''));
			} elseif ($this->CDATA == 'strip') { // Strip CDATA
				$out[1] = strtr($out[1], array('<![CDATA['=>'', ']]>'=>''));
			}

			// If code page is set convert character encoding to required
			if ($this->cp != '')
				//$out[1] = $this->MyConvertEncoding($this->rsscp, $this->cp, $out[1]);
				$out[1] = iconv($this->rsscp, $this->cp.'//TRANSLIT', $out[1]);
			// Return result
			return trim($out[1]);
		} else {
		// if there is NO result, return empty string
			// Yii::log('my_preq_match Return "" ', 'error', 'system.*');
			return '';
		}
	}

	// -------------------------------------------------------------------
	// Replace HTML entities &something; by real characters
	// -------------------------------------------------------------------
	function unhtmlentities ($string) {
		// Get HTML entities table
		$trans_tbl = get_html_translation_table (HTML_ENTITIES, ENT_QUOTES);
		// Flip keys<==>values
		$trans_tbl = array_flip ($trans_tbl);
		// Add support for &apos; entity (missing in HTML_ENTITIES)
		$trans_tbl += array('&apos;' => "'");
		// Replace entities by values
		return strtr ($string, $trans_tbl);
	}


	// -------------------------------------------------------------------
	// Parse() is private method used by Get() to load and parse RSS file.
	// Don't use Parse() in your scripts - use Get($rss_file) instead.
	// -------------------------------------------------------------------
	function Parse ($rss_url) {

		// include "simple_html_dom.php";	

		$rsBool = true; //is RSS
		// Open and load RSS file
		if ($f = @fopen($rss_url, 'r')) {
			$rss_content = '';
			while (!feof($f)) {
				$rss_content .= fgets($f, 4096);
			}
			fclose($f);

			if ($rss_content==''){
				$rss_content=file_get_contents($rss_url);
			}
			
			// Parse document encoding
			$result['encoding'] = $this->my_preg_match("'encoding=[\'\"](.*?)[\'\"]'si", $rss_content);



			// Yii::log('$result[\'encoding\']:'.$result['encoding'], 'error', 'system.*');
			// if document codepage is specified, use it
			if ($result['encoding'] != '')
				{ $this->rsscp = $result['encoding']; } // This is used in my_preg_match()
			// otherwise use the default codepage
			else
				{ $this->rsscp = $this->default_cp; } // This is used in my_preg_match()

		   if(preg_match("'<channel.*?>(.*?)</channel>'si", $rss_content, $out_channel)==false){
		   		preg_match("'<feed.*?>(.*?)</feed>'si", $rss_content, $out_channel);
		   		$rsBool=false;
		   }

		   if($rsBool){
			   	$result['type']="RSS";
			   	foreach($this->channeltags as $channeltag)
				{
					$temp = $this->my_preg_match("'<$channeltag.*?>(.*?)</$channeltag.*?>'si", $out_channel[1]);
					
					if ($temp != '') $result[$channeltag] = $temp; // Set only if not empty

					// Yii::log('$result[chtag]:'.$result[$channeltag], 'error', 'system.*');
				}
				preg_match_all("'<item(| .*?)>(.*?)</item>'si", $rss_content, $items);
				$rss_items = $items[2];
				$i = 0;
				$result['items'] = array(); // create array even if there are no items
				foreach($rss_items as $rss_item) {

					// If number of items is lower then limit: Parse one item
					if ($i < $this->items_limit || $this->items_limit == 0) {
						foreach($this->itemtags as $itemtag) {
							$temp = $this->my_preg_match("'<$itemtag.*?>(.*?)</$itemtag.*?>'si", $rss_item);
							if ($temp != '' && !empty($temp)) $result['items'][$i][$itemtag] = $temp; // Set only if not empty
						}

						if (!empty($result['items'][$i]['link'])){
							
								//convert string to html
								// $html = html_entity_decode($result['items'][$i]['description']);
								// //if theres image in description tag
								// if(!empty($tp =$this->parseContent("content", $html))){
								// 	$result['items'][$i]['img']= $tp[0];
								// } //if theres not, get OG Image
								// else{							
									$link = $result['items'][$i]['link'];

									$val=$this->getOG($link);
									$result['items'][$i]['img']= $val;
								// }
							
						}
						if(empty($result['items'][$i]['description'])){
							// echo "empty";
							if($temp = $this->my_preg_match("'<content.*?>(.*?)</content.*?>'si", $rss_item)){
								$result['items'][$i]['description'] = $temp;
							}else{
								$result['items'][$i]['description'] = "-no description-";
							}
						}

						// Strip HTML tags and other bullshit from DESCRIPTION
						if ($this->stripHTML && !empty($result['items'][$i]['description']))
							$result['items'][$i]['description'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['description'])));
						
						// Strip HTML tags and other bullshit from TITLE
						if ($this->stripHTML && !empty($result['items'][$i]['title']))
							$result['items'][$i]['title'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['title'])));
						
						// If date_format is specified and pubDate is valid
						if ($this->date_format != '' && ($timestamp = strtotime($result['items'][$i]['pubDate'])) !==-1) {
							$result['items'][$i]['pubDate'] = date($this->date_format, $timestamp);
						}

						if(empty($result['items'][$i]['img'])){
							
								if(!empty($result['items'][$i]['link'])){
									// echo $result['items'][$i]['content'];
									$tmp = html_entity_decode($result['items'][$i]['link']);

									$html2= new simple_html_dom();
									$html2->load_file($tmp);
									// $html2 = file_get_html($tmp);
										foreach ($html2->find('meta') as $element){
											if($element->property=="og:image"){
												$velz = $element->content;
												// echo $element->href .'</br>';
											}
										}
										if(!empty($velz)){$result['items'][$i]['img']=$velz;}
									// $result['items'][$i]['img']=$do;
								}
							
						}
						
						// Item counter
						$i++;
					}
				}	
		   }else{
		   		$result['type']="Atom";
		   		foreach($this->feedTags as $feedTag)
				{
					$temp = $this->my_preg_match("'<$feedTag.*?>(.*?)</$feedTag.*?>'si", $out_channel[1]);
					if ($temp != '') $result[$feedTag] = $temp; // Set only if not empty
				}
				preg_match_all("'<entry(| .*?)>(.*?)</entry>'si", $rss_content, $items);
				$rss_items = $items[2];
				$i = 0;
				foreach($rss_items as $rss_item){

					// echo $rss_item;

					if ($i < $this->items_limit || $this->items_limit == 0) {
						foreach($this->entryTags as $entryTag) {
							$temp = $this->my_preg_match("'<$entryTag.*?>(.*?)</$entryTag>'si", $rss_item);
							if ($temp != '') $result['items'][$i][$entryTag] = $temp; // Set only if not empty
						}
					}
					if(!empty($result['items'][$i]['content'])){
						if(preg_match('/<img[^>]+>/i', $result['items'][$i]['content'], $match)){
							$result['items'][$i]['img'] = $match;
						}
					}

					if(!empty($result['items'][$i]['link'])){
							$result['items'][$i]['link']=ltrim($result['items'][$i]['link']);
						}

					if(!empty($result['items'][$i]['content'])){

						//convert string to html
						$tmp = html_entity_decode($result['items'][$i]['content']);
						if(!empty($do = $this->parseContent("content", $tmp))){
							$result['items'][$i]['img']= $do[0];
						}												
					}

					// if (($timestamp = strtotime($result['items'][$i]['updated'])) !==-1) {
					// 	$result['items'][$i]['updated'] = date($this->date_format, $timestamp);
					// }
					
					// $html2 = str_get_html($rss_item);
					$html2= new simple_html_dom();
					$html2->load($rss_item);
					foreach ($html2->find('link') as $element){
						if($element->rel=="alternate"){
							$result['items'][$i]['link'] = $element->href;
							// echo $element->href .'</br>';
						}
					}
					if(empty($result['items'][$i]['img'])){
						$str = new simple_html_dom();
						$str->load_file($result['items'][$i]['link']);
						foreach($str->find('img') as $el){
							$result['items'][$i]['img']= $el->src;
						}
					}

					foreach($html2 ->find('author') as $auth){
						// echo $html2->find('email').': ';	
						foreach($auth->find('name') as $name){}
						foreach($auth->find('email') as $email){}
						$n=""; $e ="";
						if(!empty($name)){$n=strip_tags($name);}
						if(!empty($email)){$e=strip_tags($email);}
						$result['items'][$i]['author'] = $n. " (".$e." )";
						// echo $name ."(".$email.") </br>";				

					}

					if($this->stripHTML){
						
						if(!empty($result['items'][$i]['content'])){
							$tmp = html_entity_decode($result['items'][$i]['content']);
							$result['items'][$i]['content_stripped'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['content'])));
							
							//decode the string into html and put the value back
							$tmp = html_entity_decode($result['items'][$i]['content']);
							$result['items'][$i]['content']=$tmp;
						}
						if(!empty($result['items'][$i]['title'])){
							$result['items'][$i]['title'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['title'])));
						}
						if(!empty($result['items'][$i]['summary'])){
							$result['items'][$i]['summary']= strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['summary'])));
						}

						

					}
					
						if(empty($result['items'][$i]['img'])){
							if(!empty($result['items'][$i]['link'])){
									// echo $result['items'][$i]['content'];
									$tmp = html_entity_decode($result['items'][$i]['link']);

									$html2= new simple_html_dom();
									$html2->load_file($tmp);
									// $html2 = file_get_html($tmp);
										foreach ($html2->find('meta') as $element){
											if($element->property=="og:image"){
												$velz = $element->content;
												// echo $element->href .'</br>';
											}
										}
										if(!empty($velz)){$result['items'][$i]['img']=$velz;}
									// $result['items'][$i]['img']=$do;
								}

						}
					
					$i++;
				}		   		
		   }

			// $result['items_count'] = $i;
			return $result;
		}
		else // Error in opening return False
		{
			// Yii::log('Parse Return false'.$rss_url, 'error', 'system.*');
			// return False;
		}
	}
}

?>
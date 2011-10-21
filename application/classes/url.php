<?php 
defined('SYSPATH') or die('No direct script access.');

class Url extends Kohana_url {

  static function slug($str,$replace=array(),$delimiter='-')
  	{
    //setlocale(LC_ALL, 'en_US.UTF8');
  	if( !empty($replace) ) {
  		$str = str_replace((array)$replace, ' ', $str);
  	}
  
  	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
  	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
  	$clean = strtolower(trim($clean, '-'));
  	$clean = preg_replace("/[\/| ]+/", $delimiter, $clean);
  
  	return $clean;
  }
  
  static function canonical(){
    return trim(Request::current()->url(),'/');
  }
  
  static function page_id()  {
    return str_replace('/','_',self::canonical());
  }
    
  static function page_class() {
   return str_replace('/',' ',self::canonical());
  }  
  
  static function image($ext,$filehash=null,$width=100,$height=100,$format='fit'){
    return "/images/dynamic/$filehash/{$width}x{$height}x{$format}.{$ext}";
  }
      
}

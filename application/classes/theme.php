<?php defined('SYSPATH') or die('No direct script access.');

class Theme extends View {
	
  protected static $base = '';	
	
  public static function factory($pages = null, array $data = null){
  	  $arg_list = func_get_args();
  	  //if there is more than one argument && the first arg is not pages passed as an array
  	  //if(count($arg_list) > 1 && !is_array($pages)) {
  	  if(!is_array($pages)) {
  	      //if the last arg is an array i.e data
  	      if(is_array($arg_list[count($arg_list)-1])) {
	  	    $data = array_pop($arg_list);
  	      } else {
	  	    $data = null;
  	      }
	  	  $pages = $arg_list;
  	  }
  	  //just passing one item
     // if (is_string($pages)) {
  	 // 	$pages=array($pages);
  	 // }	
  	  if (!is_array($pages)) {
  	  	$pages=array(0=>null);
  	  }

    foreach ($pages as $page){
      $path = self::$base ."/". trim($page, '/');
      if ((Kohana::find_file('views', $path)) !== FALSE){
        return new View($path, $data);
      }
    }
    
    throw new Kohana_View_Exception("None of the requested views ':file' could not be found.", array(
 				':file' => join($pages,"' or '"),
 	  ));
  }
  
  static function setBase($value) {
	  self::$base = trim($value, '/');
  }
  
  static function getBase() {
	  return self::$base;
  }  
   
}
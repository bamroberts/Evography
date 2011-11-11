<?php defined('SYSPATH') or die('No direct script access.');

class Theme extends View {

  public static function factory($pages = NULL, array $data = NULL){
      if (is_string($pages)) {
  	  	$pages=array($pages);
  	  }	
  	  if (!is_array($pages)) {
  	  	$pages=array(0=>null);
  	  }
  

    foreach ($pages as $page){
      if ((Kohana::find_file('views', 'themes/'.$page)) !== FALSE){
        return new View('themes/'.$page,$data);
      }
    }
    
    throw new Kohana_View_Exception("None of the requested views ':file' could not be found.", array(
 				':file' => join($pages,"' or '"),
 	  ));
  } 
  
   
}
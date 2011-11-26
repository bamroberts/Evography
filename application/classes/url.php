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
  
  static function image($image,$width=100,$height=100,$format='fit',$missing='No Cover Set'){
    if (!is_object($image) || !$image->id){
      return "http://dummyimage.com/{$width}x{$height}/d2/fff.jpg&text=$missing";
    }
    return "/images/dynamic/{$image->filehash}/{$width}x{$height}x{$format}.{$image->ext}";
  }
  
  
  static function back($node){
    $request=Request::initial();
    $action=$request->route()->get_default('action');
    if ($action && $request->action()!=$action) 
    {
     
      $url=$request->url(array('action'=>false));
      $txt='Cancel';
      $icn='cancel';
    }
    elseif ($request->controller()!=$request->route()->get_default('controller')) 
    {
      $url=$request->url(array('controller'=>false));
      $txt='Back';
      $icn='arrow-l';
    }
    else 
    {
      $parent = $node->parent;
      $start  = $request->param('root');
      if ($parent->id==$start) 
      {
        $url=Route::url($parent->id);
        $txt='Home';
        $icn='home';
        
      }
      elseif ($parent->is_descendant($start)) {
      
        $url=Route::url($parent->id);
        $txt=Text::limit_chars($parent->name,20,'...');
        $icn='grid';
      }
      else {return false;}
    }
    return '<a href="'.$url.'"  data-direction="reverse" data-icon="'.$icn.'" >'.$txt.'</a>';     
  } 
  
  public static function site($uri = '', $protocol = NULL, $index = TRUE)
  {
  $path=parent::site($uri, $protocol, $index);
  return ($path!='/'&&strpos($path, '.') === FALSE) ? $path.'/' : $path;  
  }   
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Gallery extends Controller_Admin_Collection {

 protected $_fields=array('name', 'desc', 'published','facebook','private','theme');

function action_index(){
  	$album=ORM::factory('album',$this->id);
  	
  	if ($album->type!='gallery'){
  	  $this->fof();
  	}
  	
  	foreach ($album->children as $child){
  	  $section[]=View::factory('/admin/blocks/multipage-section')
  	    ->set('details', $child);
  	}

  	
  	$this->template->content=View::factory('/admin/multipage')
  	    ->bind('details', $album)
  	    ->bind('sections',$section)
  	    ;
	  }


}
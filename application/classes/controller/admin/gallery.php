<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Gallery extends Controller_Admin_Collection {

 protected $_fields=array('name', 'desc', 'published','facebook','private','theme');

function action_index(){
  	$album=$this->node;
  	
  	if ($album->type!='gallery'){
  	  $this->fof();
  	}
  	
  	
  	foreach ($album->children as $child){
  	  $section[]=$this->getView('blocks/gallery-section')//View::factory('/admin/blocks/gallery-section')
  	    ->set('details', $child);
  	}

    if (!isset($section)){
    $section=array();
    $empty="-empty-";
    }
  	
  	
  	$this->template->content=$this->getView('gallery')//View::factory('/admin/gallery')
  	    ->bind('gallery' , $album)
  	    ->bind('sections', $section)
  	    ->bind('empty'   , $empty)
  	    ;
	  }


}
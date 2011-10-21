<?php defined('SYSPATH') or die('No direct script access.');
 
 class Controller_Gallery_Gallery extends Controller_Gallery_Collection {

    function action_view(){
		  $this->template->content = Theme::factory(array($this->theme.'/gallery','default/gallery'))
		    ->bind('sections',$sections)
		    ->bind('collection',$collection);
		  
		  $collection=$this->node;
		  $this->template->title=$collection->name;
		  $this->template->meta_description=$collection->desc;
		  
		  $sections=$collection->children; 
		  
		  return;
		}
 }
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Menu extends Master_Gallery {

  public function before(){
    parent::before();
    //if (!$this->intenal) {throw new HTTP_Exception_404('File not found!');}
  }

	public function action_index()
	{ 
	   //sent_id or rootnode
	   $id=$this->request->param('node',$this->request->param('rootnode'));
	   $item=ORM::factory('album',$id);
	   if (!$item->id) return;
	   
	   if ($item->type=='gallery'){
         $children=$item->children;
         $parent=$item;         
     } else {
         $children=$item->parent->children;
         $parent=$item->parent;
     }
     
     $pages[]= array(
        'selected'=>($parent->id==$item->id)?true:false,
        'link'=>Route::url($parent->id),
        'name'=>'Home',
     );
     foreach ($children as $child) {
       $pages[]= array(
        'selected'=>($child->id==$item->id)?true:false,
        'link'=>Route::url($child->id),
        'name'=>$child->name,
        );     
     }
     $this->template->content = Theme::factory(array($this->theme.'/blocks/menu','default/blocks/menu'))
                                   ->bind('pages', $pages);
	}
}
	
	
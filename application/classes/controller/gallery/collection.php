<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Collection extends Master_Gallery {

	

	
	function action_index(){  
	  return $this->action_view();
  }
  
  function action_grid(){
    $this->style="grid";
	  return $this->action_view();
	}
	
	 function action_list(){
	   $this->style="list";
	  return $this->action_view();
	}
	
	function action_view(){
	  //$id=$this->request->param('node',$this->masternode);
	  $this->template->page_link=$this->request->url(array('controller'=>'','action'=>'','id'=>''));	
	  //die();
	  //echo $id;
	  
		$collection=$this->node;
				//	->and_where('user_id','=',$this->user->id)
				//	->and_where('id','=',$id)
				//	->find();
		
		if (!$collection->id){
			throw new HTTP_Exception_404('File not found!');
		}
		
    $this->template->collection_title=$this->template->title="{$collection->name}";
		$this->template->collection_desc=$collection->desc;
		$this->template->cover=$collection->cover;
		
				
		/*
if ($collection->children==0 && $collection->albums->count_all()==1){
		    $album_page = Request::factory('gallery/album/view/'.$collection->albums->find())->execute()->body();
            $this->response->body($album_page);
            $this->auto_render = FALSE;
		}
*/
		
		
		
		$children=$collection->children;
		$albums=array(); 						
		$this->template->content = Theme::factory(array("{$this->theme}/blocks/collection/{$this->style}","default/blocks/collection/{$this->style}"))
      ->bind('collection', $collection)
			->bind('children', $children)
			->bind('albums', $albums)
			->bind('pagination', $pagination);
	}
}
	?>


 
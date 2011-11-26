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
    $count=$collection->albums->count_all();
    
    //Set album pagination values
    $pagination = Pagination::factory(array(
      'total_items'    => $count,
      'items_per_page' => Arr::get($_REQUEST['current'],'limit',20),
      'item_type'      => 'child'
    ));
		
		$children=$collection->albums
		        ->where('published','=',1)
		        ->limit($pagination->items_per_page)
        		->offset($pagination->offset)
        		->order_by('order','DESC')
        		->find_all();
  
    $media=Theme::factory(array("{$this->theme}/collection/{$this->style}","default/collection/{$this->style}"))
			->bind('collection', $collection)
			->bind('children', $children);
		
		
		//$children=$collection->children;
		//$albums=array(); 						
		$this->template->content = Theme::factory(array("{$this->theme}/collection","default/collection"))
      ->bind('collection', $collection)
			->bind('media', $media)
			->bind('pagination', $pagination);
	}
}
	?>


 
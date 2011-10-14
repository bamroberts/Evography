<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Collection extends Master_Gallery {

	
	function action_index(){
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
		
		if ($collection->type=='gallery'){
		  $this->template->content = Theme::factory(array($this->theme.'/gallery','default/gallery'))
		  ->bind('sections',$sections)->bind('collection',$collection);
		  
		  $this->template->title=$collection->name;
		  $this->template->meta_description=$collection->desc;
		  
		  $sections=array();
		  $albums=$collection->children; 
		  foreach ($albums as $key=>$album){
		    $sections[$key]['name']="{$album->name}";
		    $sections[$key]['factory']=Route::url($album->id,array('format'=>'.part'));
		    
		    
		    
		   // "/".$this->request->param('user')."/{$album->type}/view/{$album->id}";
		    
		    
		    $sections[$key]['data']['multi']=true;
		    if ($album->type=='album'){
		      $sections[$key]['data']['limit']=40;
 		      //$sections[$key]['data']['type']='images-smallgrid';
		    }
		  }
		  return;
		}
		
		/*
if ($collection->children==0 && $collection->albums->count_all()==1){
		    $album_page = Request::factory('gallery/album/view/'.$collection->albums->find())->execute()->body();
            $this->response->body($album_page);
            $this->auto_render = FALSE;
		}
*/
		
		
		
		$children=$collection->children;
		$albums=array(); 						
		$this->template->content = View::factory('themes/default/collections')
            ->bind('collection', $collection)
			->bind('children', $children)
			->bind('albums', $albums)
			->bind('pagination', $pagination);
	}
	
}
	?>


 
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Album_Master extends Master_Gallery {
//master class to handle all Album calls


	public function action_index()
	{
	  //should never be used, collection controller should be used for all higher level interactions
	  return $this->action_view();
	}
	
	public function data(){
	  return $this->node
      ->images
      ->limit($this->pagination()->items_per_page)
      ->offset($this->pagination()->offset)
      ->find_all();
	}
	
	public function pagination(){
	  if (isset($this->pagination)) return $this->pagination;
	  	$count=$this->node->images->count_all();
	    return $this->pagination=Pagination::factory(
  	           array(
                  'total_items'    => $count,
                  'items_per_page' => Arr::get($_REQUEST['current'],'limit',20),
                  'item_type'      => 'image',
                  )
                );	  
	}
	
	public function json(){
	  $data=array('results'=>$this->data()->as_array());
	  return json_encode(Arr::merge((array) $this->pagination,$data));
	}
	
	public function part(){
	  
	  if (!$type=$this->node->style->name) {
	   $type='grid';
	  }
    $type=Arr::get($_REQUEST['current'],'type',$type);
    if (!$this->pagination()->total_items) $type="empty";
    
   $view=Theme::factory(array("{$this->theme}/blocks/album/$type","default/blocks/album/$type"))
    ->set('images',$this->data())
    ->set('details',$this->pagination()->details())
    ->bind('data',$data)
    ;
   
    
    //$data=(string) $this->template->script_options;
    foreach ($this->template->script_options->flat() as $key=>$value) { 
     $data.="data-{$key}=\"{$value}\""; 
    }
    
	  return $view;
  }
	
	public function action_view()
	{   
	  switch ($this->request->param('format')){
	   case '.ajax':
	   case '.part':
	     return $this->template->content=$this->part();
	   break;
	   case '.json':
	     return $this->template->content=$this->json();
	   break;
	  }
	
		$controller=$this->request->controller();
		$this->template->content = Theme::factory(array("{$this->theme}/$controller","default/$controller"))
			->set('album', $this->node)
			->set('media',$this->part())
			->bind('comments',$comments)
			->bind('comment_count',$count)
			->set('pagination', $this->pagination);
		
		
		$comments=Request::factory( Route::url($this->node->id, array('controller'=>'comments','format'=>'.part')) )->execute();
		
//	if ($this->node->settings('cart')){	
	//	foreach ($this->node->prices as $price) {
//		  echo "Category:{$price->category}  Name: {$price->name} Price:{$price->price}<br />";
//		
//		}
//}
		
		}
	
		
	function action_upload(){
	  $album=ORM::factory('album',$this->request->param('id'));
	  if(!$album->open) {
	   throw new HTTP_Exception_404('File not found!');
	  }
	  $_REQUEST['current']['type']='album-upload';
	  return $this->action_view();
	}
	
}
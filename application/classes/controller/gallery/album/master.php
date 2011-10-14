<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Album_Master extends Master_Gallery {
//master class to handle all Album calls


	public function action_index()
	{
	  //should never be used, collection controller should be used for all higher level interactions
	  return $this->action_view();
	}
	
	public function action_view()
	{   
	
		//$id=$this->request->param('id');
		//$id=$this->request->param('node');
		//$album = ORM::factory('album',$id);
		$album=$this->node;		
		
	//	if (!$album->id || $album->type!=$this->request->controller()){
	//		throw new HTTP_Exception_404('File not found!');
	//	}
		$this->check_auth($album);
		$this->template->title="{$album->parent->name} - {$album->name}";
		$this->template->meta_description=$album->desc;
		 
		$count = $album->images->count_all();
		/*
if (!$count){
		  $this->template->content = "No images have been uploaded.";
		  return;
		
}*/
        $pagination = Pagination::factory(array(
        'total_items'    => $count,
        'items_per_page' => Arr::get($_REQUEST['current'],'limit',20),
        ));
		        
		        
		    if($album->open){$_GET['sort']=Arr::get($_GET,'sort','DESC');}    
        $images=$album
        		 ->images
        		 ->limit($pagination->items_per_page)
        		 ->offset($pagination->offset)
        		 //->order_by(Arr::get($_GET,'order','order'),Arr::get($_GET,'sort','ASC'))
        		 ->find_all();
        
        /*

        $comment_pagination = Pagination::factory(array(
        'total_items'    => $album->comment->where('approved','=',1)->count_all(),
        'items_per_page' => Arr::get($_REQUEST['current'],'limit',10),
        'current_page'   => array('source' => 'query_string', 'key' => 'comments'),
        ));
		        
        $comments=$album
        		 ->comment
        		 ->where('approved','=',1)
        		 ->limit($comment_pagination->items_per_page)
        		 ->offset($comment_pagination->offset)
        		 ->order_by('add_date','DESC')
        		 ->find_all();
    
*/
    
    $type =($album->type)?''.$album->type:'album';
    $type.=($album->theme)?'-'.$album->theme:'';
    
    $type=Arr::get($_REQUEST['current'],'type',$type);
		$this->template->content = Theme::factory(array("{$this->theme}/{$type}",'default/'.$type))
			->bind('album', $album)
			->bind('images', $images)
			->bind('count', $count)
			->bind('pagination', $pagination)
			->bind('upload', $upload)
			->bind('comments', $comments)
			->bind('comment_pagination', $comment_pagination)
			;
			
		if ($album->open && $this->request->action()=='upload') {
		  if (Arr::get($_GET,'ajax',false)||Auth::instance()->logged_in()) {
		    $upload=Request::factory("admin/album/{$album->id}/upload")->execute();
		  }
		} 
			if (true){
			
		//if ($this->request->is_initial() && $album->parent->type=='multiview') {
		  $this->template->collection_title =$album->parent->name;
		  $this->template->collection_desc  =$album->parent->desc;
		  $this->template->cover=Arr::get($images,0,$album->parent->cover);;
      $head =  Theme::factory(array("{$this->theme}/album-head",'default/album-head'))
			  ->bind('album', $album)
			  ->bind('images', $images);
      $this->template->content=$head.$this->template->content;
    }
	}
	
public function action_image()
	{   
		$id=$this->request->param('id');
		$image = ORM::factory('image',$id);
		$album = $image->albums->where('id','=',$this->request->param('node'))->find();
		if (!$album->id){
			throw new HTTP_Exception_404('File not found!');
		}
		
		//If format=jpg then redirect to raw image - used for lightbox
    if ($this->request->param('format')=='jpg'){
      $this->request->redirect("/images/dynamic/{$image->filehash}/1000x1000xfit.{$image->ext}");
      return;
    }
    
	  $this->check_auth($album);
		  $image->views++;
		  $image->save();
			
	    $next= $image->next();
	    $previous= $image->previous();
        
		$this->template->content = View::factory('image')
			->bind('album', $album)
			->bind('image', $image)
			->bind('next',$next)
			->bind('previous', $previous);
	}

	function check_auth($album){
	     
	 	 if (
		    $album->private && 
		    Auth::instance()->logged_in(array("album_$album->id"))=== FALSE &&
		    Auth::instance()->logged_in(array('admin'))=== FALSE
		    ) {
		  	  Session::instance()->set("requested_url","/".$this->request->uri()); 
              //if we are logged in then we don't have high enough priveleges
              if (Auth::instance()->logged_in()){
                $this->request->redirect('admin/home/noaccess');
              }else{
                $this->request->redirect("admin/home/login/?username=$album->name");
              }
	    }
       
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
<?php defined('SYSPATH') or die('No direct script access.');
 
 class Controller_Gallery_Guestbook extends Controller_Gallery_Album_Master {

  public function action_view(){
  //$this->template->meta_description=$album->desc;
		$album=$this->node;		 
		
		//if no images send enpty album message -- or hide?
    if (!$count = $album->comment->count_all()){
		    $this->template->content = "<h1 class='error'>There are no comments in this guestbook</h1>";
		    return;
		}

    //Set album pagination values
    $pagination = Pagination::factory(array(
      'total_items'    => $count,
      'items_per_page' => Arr::get($_REQUEST['current'],'limit',20),
    ));
		
		   
    $comments=$album
      		 ->comment
      		 ->where('approved','=',1)
      		 ->limit($pagination->items_per_page)
      		 ->offset($pagination->offset)
      		 ->order_by('add_date','DESC')
           ->find_all();        
    
    //$type =($album->type)?''.$album->type:'album';
   // $type=$album->style->name?$album->style->name:'grid';
   // $type=Arr::get($_REQUEST['current'],'type',$type);
    $media=Theme::factory(array("{$this->theme}/blocks/comments","default/blocks/comments"))
    ->bind('comments',$comments);
    
    $controller=$this->request->controller();
		$this->template->content = Theme::factory(array("{$this->theme}/$controller","default/$controller"))
			->bind('album', $album)
			->bind('media',$media)
			//->bind('images', $images)
			//->bind('count', $count)
			->bind('pagination', $pagination)
			//->bind('upload', $upload)
			//->bind('comments', $comments)
			//->bind('comment_pagination', $comment_pagination)
			;
			
		/*
if ($album->open && $this->request->action()=='upload') {
		  if (Arr::get($_GET,'ajax',false)||Auth::instance()->logged_in()) {
		    $upload=Request::factory("admin/album/{$album->id}/upload")->execute();
		  }
		} 
		
			
		if ($this->request->is_initial() && $album->parent->type=='gallery') {
		  $this->template->collection_title =$album->parent->name;
		//  $this->template->collection_desc  =$album->parent->desc;
		  $this->template->cover=Arr::get($images,0,$album->parent->cover);
      $head =  Theme::factory(array("{$this->theme}/album-head",'default/album-head'))
			  ->bind('album', $album)
			  ->bind('images', $images);
      $this->template->content=$head.$this->template->content;
    }
*/

  }

  public function action_post(){
    return $this->action_view();
  }
 }
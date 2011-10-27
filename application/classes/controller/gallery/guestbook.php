<?php defined('SYSPATH') or die('No direct script access.');
 
 class Controller_Gallery_Guestbook extends Controller_Gallery_Album_Master {

  public function part(){
  
  }
  
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
      'item_type'      => 'entry'
    ));
		
		   
    $comments=$album
      		 ->comment
      		 ->where('approved','=',1)
      		 ->limit($pagination->items_per_page)
      		 ->offset($pagination->offset)
      		 ->order_by('add_date','DESC')
           ->find_all();        
    
    $media=Theme::factory(array("{$this->theme}/blocks/comments","default/blocks/comments"))
    ->bind('comments',$comments);
    
    if ($this->request->param('format')=='.part') {
      return $this->template->content=$media;
    }
    
    $controller=$this->request->controller();
		$this->template->content = Theme::factory(array("{$this->theme}/$controller","default/$controller"))
			->bind('album', $album)
			->bind('media',$media)
			->bind('pagination', $pagination);
		
  }

  public function action_post(){
    return $this->action_view();
  }
 }
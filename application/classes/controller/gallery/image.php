<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Image extends Master_Gallery {
  
  public function before(){
    //if requested method doesn't exist use default
    //we do this as default actions are set based on albums settings and don't always exist
    //This also comes before the parent::before as the action is overridden by accound suspention and password protection
    if (!method_exists($this, "action_".$this->request->action())){
      $this->request->action('index');
    }
    
    parent::before();
  }
  
  public function json(){
    $image=ORM::factory('image',$this->request->param('id'));
    
    $return=array(
      'name'=>$image->name,
    //  'desc'=>$image->desc,
      'size'=>url::image($image,1024,1024,'fit'),
      'comments'=> $image->comment->count_all(),
     // 'forsale'=> $image->pricing->where('availible','=',1)->count_all()?true:false,
      'link'=>array(
          'album'=>Route::url($image->album_id,array('controller'=>'comments','id'=>$image->id)),
          'comments'=>Route::url($image->album_id,array('controller'=>'comments','id'=>$image->id)),
          'purchase'=>Route::url($image->album_id,array('controller'=>'buy','id'=>$image->id)),
        ),
          
      );
    $this->template->content = json_encode($return);  
      
    

  }
  
  
  public function action_index(){
    switch ($this->request->param('format')){
    case 'json':
      return $this->json();
      break;
    }
  
  
    $image=ORM::factory('image',$this->request->param('id'));
    if (!$image->id or $image->album_id!=$this->request->param('node')) {
      return $this->fof();
    } 
    
    $album=$image->album;
    
   // if ($album)
    
    $image->views++;
    $image->save();
    
    //  If format is set to jpg serve up image.  Used to trick lightbox.
    if ($this->request->param('format')=='jpg'){
      $this->request->redirect("/images/dynamic/{$image->filehash}/1000x1000xfit.{$image->ext}",301);
      return;
    }
		
		
	  $next= $image->next();
	  $previous= $image->previous();
    /*

    $count=$image
      		 ->comments
      		 ->where('approved','=',1)
      		 ->count_all();
    
    //Set album pagination values
    $pagination = Pagination::factory(array(
      'total_items'    => $count,
      'items_per_page' => Arr::get($_REQUEST['current'],'limit',20),
      'source'=>'query',
      'key'   =>'comment-page'
      
    ));
			   
    $comments=$image
      		 ->comments
      		 ->where('approved','=',1)
      		 ->limit($pagination->items_per_page)
      		 ->offset($pagination->offset)
      		 ->order_by('add_date','DESC')
           ->find_all();        
    
    //$type =($album->type)?''.$album->type:'album';
   // $type=$album->style->name?$album->style->name:'grid';
   // $type=Arr::get($_REQUEST['current'],'type',$type);
    $comment_block=Theme::factory(array("{$this->theme}/blocks/comments","default/blocks/comments"))
    ->bind('comments',$comments)
    ->bind('pagination',$pagination)
    ;
*/
    $comments=Request::factory( Route::url($this->node->id, array('controller'=>'comments','id'=>$image->id,'format'=>'part')) )->execute();
        
		$this->template->content = Theme::factory(array("{$this->theme}/image","default/image"))

			->bind('album', $album)
			->bind('image', $image)
			->bind('comments', $comments)
			->bind('next',$next)
			->bind('previous', $previous);
  
//  $this->ass=$image;
    
  }
  
  
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Image extends Master_Gallery {
  
  public function before(){
    //if requested method doesn't exist use default
    //we do this as default actions are set based on albums settings and don't always exist
    //This also comes before the parent::before as the action is overridden by accound suspention and password protection
    if (!method_exists($this, $this->request->action('index'))){
      $this->request->action('index');
    }
    
    parent::before();
  }
  
  
  public function action_index(){
  
    $image=ORM::factory('image',$this->request->param('id'));
    if (!$image->id or $image->album_id!=$this->request->param('node')) {
      return $this->fof();
    } 
    
    $album=$image->album;
    
   // if ($album)
    
    $image->views++;
    $image->save();
    
    //  If format is set to jpg serve up image.  Used to trick lightbox.
    if ($this->request->param('format')=='.jpg'){
      $this->request->redirect("/images/dynamic/{$image->filehash}/1000x1000xfit.{$image->ext}",301);
      return;
    }
		
	    $next= $image->next();
	    $previous= $image->previous();
        
		$this->template->content = View::factory('image')
			->bind('album', $album)
			->bind('image', $image)
			->bind('next',$next)
			->bind('previous', $previous);
    
  }
}
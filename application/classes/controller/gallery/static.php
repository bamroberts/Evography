<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Static extends Master_Gallery {

  public function before(){
    parent::before();
    if (!method_exists($this, $this->request->action())){
      $this->page=$this->request->action();
      $this->request->action('index');
    }
  }

	public function action_index()
	{ 
	  echo $this->template->content= Theme::factory(array("{$this->theme}/static/{$this->page}","default/static/{$this->page}"));
  }
  
  	public function action_404()
	{  
	
	   echo "what";
     $this->response->status(404);
	   $this->page='404';
	   return $this->action_index();
  }
}
	
	
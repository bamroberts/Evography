<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Static extends Master_Gallery {

  public function before(){
    parent::before();
    if (!method_exists($this, "action_".$this->request->action())){
      $this->page=$this->request->action();
      $this->request->action('index');
    }
  }

	public function action_index()
	{ 
	   $this->template->content= Theme::factory(array("{$this->theme}/{$this->page}","default/{$this->page}"));
  }
  
  	public function action_404()
	{  
     $this->response->status(404);
	   $this->page='static/404';
	   return $this->action_index();
  }
}
	
	
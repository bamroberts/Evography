<?php
 defined('SYSPATH') or die('No direct script access.');

 class Master_Admin extends Master_Master
  {
     public $template = 'templates/admin';
      // Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
      // Can be set to a string or an array, for example 'login' or array('login', 'admin')
      // Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
     public $auth_required =  array('login');
     //public $auth_required = FALSE;
      // Controls access for separate actions
      // 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
      // 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
  	 public $secure_actions = FALSE;
     
     public $user_id=FALSE;
  
     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
     public function before()
      {
         // Run anything that need ot run before this.
         parent::before();
          #Open session
         // $this->session= isset($_GET['sid']) ? Session::instance(NULL, $_GET['sid']):Session::instance();
	        
	        // place session in cookie (appended by Swiff.Uploader - appendCookieData)
          //$_COOKIE['session'] = $_POST['session'];
	        $this->session= isset($_POST['session']) ? Session::instance(NULL, $_POST['session']):Session::instance();
	        
	        
	        if ($user=Auth::instance()->get_user()) {$this->user_id=$user->id;}
	        if (!$this->request->is_initial()){$this->auto_render=FALSE;}
	            
	        #Check user auth and role
	        $action_name = $this->request->action();
	        if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
	                || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
	                Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))
					  { 
					  	$this->auth();
					  	
					     
					    
					  } 
				
        $this->template->content          = '';	  
					  
         if($this->auto_render)
          {
            // Initialize empty values
            $this->template->title            = '';
            $this->template->titlepart        = array();
            $this->template->slideshownumber   = '';
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copywrite   = '';
            $this->template->page             = '';
            $this->template->flash            = '';
            $this->template->styles           = array();
            $this->template->scripts          = array();
          }
     //  if (isset($this->model)){
//         $model=$this->model;  
//         $this->model=new $model();
//       }
      
      
      }
      
      

     /**
      * Fill in default values for our properties before rendering the output.
      */
     public function after()
      {
         if($this->auto_render)
          {
             // Define defaults
             $styles                  = array( 
                                            'assets/css/960.css' => 'screen',
                                            'assets/css/admin_alecmaxwell.css' => 'screen',                                                                                                    
                                          );
             $scripts                 = array(
                                          );
             

             // Add defaults to template variables.
             $this->template->styles  = array_merge($styles,$this->template->styles);
             $this->template->scripts = array_merge($scripts,$this->template->scripts);
             $this->template->page    = $this->request->param('controller');
             if ($this->template->title== ''){
              $this->template->titlepart[]="Admin System";
              $this->template->title= join(array_reverse($this->template->titlepart),' - ');
              $this->template->flash   		  = Hint::render();
             }
           }
           
         /*
if (!$this->request->is_initial()){
            $this->response->body($this->template->content);
*/
         //$this->request->response=$this->template->content;$this->request->render();return;
         
         //}   
         // Run anything that needs to run after this.
         parent::after();
      }

   public function auth(){
   //remember where we were trying to get to.
              Session::instance()->set("requested_url","/".$this->request->uri()); 
              //if we are logged in then we don't have high enough priveleges
              if (Auth::instance()->logged_in()){
                $this->request->redirect('admin/user/noaccess');
              }else{
                $this->request->redirect('admin/user/login');
              }
   }    
      
   public function action_index(){
   	$this->action_view();
   }
   
   var $links=array(
  	'index'=>1,'edit'=>1,'delete'=>1
  	);
   public function view_links(){
   
    $link = new stdClass();
    foreach ($this->links as $key=>$settings){
    $$key= new stdClass();     
    	$$key->link=URL::site(Request::current()->uri(array('action' => $key)));
    	$$key->class=$key;
    	$$key->text=$key;	
    $link->$key=$$key;	
    }
    
     return ($link);
   }
   public function action_view(){
   	
   	$this->template->content = View::factory('pages/admin/list')
      ->bind('columns',$columns)
      ->bind('results', $results)
      ->bind('links',$links)
      ->bind('pagination', $pagination);
      
    
    $table = ORM::factory($this->model);
    $columns = $table->list_columns();
    $count   = $table->count_all();
    $links   = $this->view_links();
    
    $pagination = Pagination::factory(array(
      'total_items'    => $count,
      'items_per_page' => 20,
    ));
    $results=$table
        	->limit($pagination->items_per_page)
        	->offset($pagination->offset)
        	->find_all();  
   }

  public function action_edit(){
      $this->action_add();
   }
   
   public function action_add(){
      
   	  $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
     
      $data = ORM::factory($this->model,$this->request->param('id'));
      $columns = $data->list_columns();
    //  $columns=Arr::merge($data->list_columns(),$data->_model);
 $columns=$data->list_columns();
     
      
      if ($_POST) {
      	$data->values($_POST);
      	if ($data->check()) { $data->save(); }
      	else {echo 'errors!!!';}
      }
      if ($this->request->action()=='add' and $data->id){
        $this->request->redirect($this->request->uri(array('action'=>'edit','id'=>$data->id)));       
      }
      if ($this->request->action()=='edit' && !$data->id) {throw new HTTP_Exception_404('File not found!');}

      
   }
   
   public function action_delete(){
   	  $this->template->content = View::factory('pages/admin/delete', $data);
   	  //ORM::factory($this->model,$this->request->param('id'))->delete();
   }
   
   public function action_default($page=array()) {
      $layout                   = array();
      $menu                     = array();
      
      $menu['section']         = Request::instance()->controller;
      $menu['selected']        = Request::instance()->action;
      $menu['submenu']         = $this->submenu;
      $layout['submenu']       = View::factory('blocks/menu', $menu)->render();
      $layout['content']       = View::factory("pages/{$menu['section']}_{$menu['selected']}", $page)->render();
      $this->template->content = View::factory('layouts/'.$page['layout'], $layout);
  }
  
 
 }

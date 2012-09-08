<?php
 defined('SYSPATH') or die('No direct script access.');

 class Master_Gallery extends Master_Master
  {
     public $base = '';
     public $theme = 'default';
     public $template = 'template';
    
     //public $template = 'themes/alecmaxwell.co.uk/template';

     function getViewPath($page) {
		return "{$this->base}/{$this->theme}/{$page}";
	}

     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
     public function before()
      {
      	 Theme::setBase('themes');
      
         // Run anything that need ot run before this.
         parent::before();
         $this->session = Session::instance();
          //Load object versions of route params
          $this->user= Orm::factory('user',$this->request->param('user'));
          $this->account= $this->user->account;
          $this->node   = Orm::factory('album',$this->request->param('node'));
          $this->root   = Orm::factory('album',$this->request->param('root'));
          
         //if subscription is not active i.e. account is suspended
          if($this->account_suspended()){
            //if we are not at the root of this domain redirect
            if ($this->root->id!=$this->node->id){
              $this->request->redirect(Route::url($this->root->id));
            }
            //set the action to offline. Universal actions stored in the template and accessable regardless of class 
            $this->request->action('offline');
            return; //no point in doing the rest.
          }   
           
          if (!$this->node->published) {
            $this->request->action('fof');
            return;
          }
          
          //does this album require a password?
          if (!Access::permission($this->node)){
                //change action to login page
                $this->request->action('login');
          }
                      
        //load and configure theme 
         $theme  = Orm::factory('theme',$this->request->param('theme'));
         if ($theme->name!=$this->theme) {
           $this->theme=$theme->name; 
           
           //only bother flushing template if we are going to render it.
           if($this->auto_render){
             if (Request::user_agent('mobile')) {$this->theme = 'default';}
			 $this->template = $this->getTemplate();     
			 }
         }
         
         $this->init_template();
          
         //add theme css and js 
        
         $this->template->script_options   = Config::instance()->load('javascript');
         
                   //$this->user=ORM::factory('user')->where('username','=',$this->request->param('account'))->find();
	    //if (!$this->user->id) { echo 'Name='.$this->request->param('user'); throw new HTTP_Exception_404('File not found!');}
	    
	     
      }
      
      private function init_template(){
                    //echo $this->request->param('root');
            //echo $this->request->param('node');
            // Initialize empty values
            $this->template->site             = $this->root;
            $this->template->node             = $this->node;
            $this->template->title            = $this->node->name;
            $this->template->description      = $this->node->desc;
            //$this->template->meta_keywords  = $this->node->tags;
            $this->template->title_part        = array();
            $this->template->slideshownumber  = '';
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copywrite   = '';
            $this->template->collection_title = '';
            $this->template->collection_desc  = '';
            $this->template->cover            = '';            
            $this->template->content          = '';
            $this->template->page             = '';
            $this->template->styles           = array();
            $this->template->scripts          = array();
            $this->template->page_link=$this->request->url();
            $this->template->breadcrumbs      = '';
          
      }
      
      
      public function breadcrumbs(){
        //$tree=$this->node->parents;
        return Theme::factory(array("{$this->theme}/blocks/breadcrumbs","default/blocks/breadcrumbs"))
        ->bind('node',$this->node)
        ->bind('root',$this->root); 
              
       //get url path Ben's - Weddings - Bry and Lukes - Image
       //get bread crumbs ^ with links
       //site map:
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
             								               'assets/css/admin_alecmaxwell.css' => 'screen',                                 
                                            'assets/css/web_alecmaxwell.css' => 'screen' ,                               
                                            'assets/css/mediaboxAdvBlack.css' => 'screen',
                                            'assets/css/960.css' => 'screen',                               
                                            'assets/css/text.css' => 'screen', 
                                            'assets/css/reset.css' => 'screen'                                                                 
                                          );
             $scripts                 = array(
                                            'assets/javascript/alecmaxwell.js',
                                            'assets/javascript/jd.gallery.transitions.js',
                                            'assets/javascript/jd.gallery.set.js',
                                            'assets/javascript/jd.gallery.js',
                                            'assets/javascript/mootools-1.2-more.js',
                                            'assets/javascript/mootools-1.2.4-core-yc.js'
                                          );
             
$scripts =array();
             // Add defaults to template variables.
             $this->template->styles  = array_merge($styles,$this->template->styles);
             $this->template->scripts = array_merge($scripts,$this->template->scripts);
           // if ($this->template->title== ''){
           //   $this->template->titlepart[]="EVOGRAPHY";
           //   $this->template->title.= join(array_reverse($this->template->titlepart),' - ');
           //  }
             $this->template->page=join($this->request->param(),' ');
             
             if (!$this->template->breadcrumbs) $this->template->breadcrumbs = $this->breadcrumbs();
             $this->template->title = strip_tags($this->template->breadcrumbs);
            
          //  if (isset($this->asset)$this->template->node)
             
           }
            //echo debug::vars($this);
         // Run anything that needs to run after this.
         parent::after();
      }
  
  function account_suspended(){
     $this->update_subscription_details();
     return ($this->account->active!=1);    
  }
   
   function action_offline() {
      //$this->template = View::factory("site/template");
      $this->init_template();  
      $this->template->content=View::factory('themes/default/offline')
        ->bind('site',$this->account);
      
   } 
   
   function permission($node) {
          if (is_string($node) || is_numeric($node)) {
            $node=Orm::factory('album',$node);
          }
          if ($node->password->active){
              $password=$this->node->password;
              //do we have a session password for this password file (remember if might be inherited not just for this album) 
              if ($password->phrase!='' && md5($password->phrase) == $this->session->get("password_{$password->id}") ) {
                return true;
              }
              //if not are we logged in and have access
              if ($password->user_ids!='' 
               && Auth::instance()->get_user() 
               && stristr(",{$this->account->user_id},{$password->user_ids},", ",".Auth::instance()->get_user()->id."," ) 
              ) {
                return true;
              }
          return false;
          }
    }
   
   
   
   function action_login() {
       $password=$this->node->password;
       $columns=array();
       if ($password->phrase!='') {
         $columns+=array(
          'phrase'=>array('name'=>'Pass phrase','formtype'=>'password'),
         );
       }
       if ($password->user_ids!='') {
         $columns+=array(
          'username'=>array('name'=>'Username / email'),
          'password'=>array('formtype'=>'password'),
         );
       }
       
       //echo DEbug::vars($columns);
       $this->template->content=Theme::factory(array("{$this->theme}/login","default/login"))
       ->set('node', $this->node)
       ->bind('columns', $columns)
       ->bind('data', $data)
       ->bind('errors', $errors);
       
       if ($post=$this->request->post())
       {
         //Pass phrase login
         if (Arr::get($columns,'phrase') && $phrase = Arr::get($post,'phrase'))
         {
           if ($password->phrase == $phrase) 
           {
             //make sure if we persist username that it doesn;t interfeer with login
             unset($post['username']);
             
             $this->session->set("password_{$password->id}",md5($phrase));
             //We are logged in - redirect back to the page
             $this->request->redirect($this->request->uri());
           } 
           
           else 
           {
             $errors['phrase']="The pass phrase was incorrect";
           } 
         }
         
         //Username and password login
         if (Arr::get($columns,'username') && $username = Arr::get($post,'username')) 
         {
            $data['username']=$username;
            //alows us to login using either username or email.
            //If supplied input is a valid email look up username.
              $rules=array(
                'email' => array(
        				    array('email'),
        			   ),
        			);
        			$email=Validation::factory($rules);
        			if ($email->check())
        			{
        			  $user=Orm::factory('user')->where('email','=',$username)->find();
        			  if ($user->username) 
        			  {
        			    $username=$user->username;
        			  }
        			}
              
              #Check Auth
              Auth::instance()->login($username, Arr::get($post,'password'),Arr::get($post,'remember_me'));
              $status = Auth::instance()->logged_in();
         
              #If the post data validates using the rules setup in the user model
              if ($status)
              {   
                if (stristr(",{$this->account->user_id},{$password->user_ids},", ','.Auth::instance()->get_user()->id.',' )) 
                { 
                  //We are logged in - redirect back to the page
                  $this->request->redirect($this->request->uri());
                }
                
                else
                {
                  Auth::instance()->logout();
                  $errors['username']="Your username and password are valid but do not grant you access to this album";
                }
              }
              
              else
              {
             	  $user_exists=$user->where('username','=',$username)->count_all();
                if (!$user_exists) 
                {	
               	  $errors['username']="Username not found";
               	} 
               	
               	else 
               	{ 
                  $errors['password']= "Incorrect password.";
              	}         
              }
             
         }
      }
   }    
}


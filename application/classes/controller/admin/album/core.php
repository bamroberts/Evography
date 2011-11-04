<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Album_core extends Master_Admin {
  protected $_model='album';
  protected $_fields=array('name', 'desc', 'published');
  
  public function before(){
  // die();
    parent::before();
    $this->id=$this->request->param('id');
    $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'collection','action'=>'','id'=>'')),'Collections');

    $start_node=ORM::factory($this->_model,Auth::instance()->get_user()->start_node);
    
    //Check and set access level
    if ($this->id){
      $this->node=ORM::factory($this->_model,$this->id);
      
      
      if (  !$this->node->id
            || // or is node user start node or a child of?
            //if collection is before or after start node it is out of user scope.
            ($this->node->lft < $start_node->lft || $this->node->rgt > $start_node->rgt)
            ||  //of requested node is not of this controller type
            ($this->node->type!=$this->request->controller())
          )
        {
          $this->fof();
        }
      
      //Set breadcrums for parents upto start node.
      foreach ($this->node->parents as $parent){
        if($parent->level < $start_node->level) continue;
        $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>$parent->type,'action'=>'','id'=>$parent->id)),$parent->name);
      }
      
      //Sec current record if doing edit /or other action
      if (Route::$default_action != $this->request->action()){
	      $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('action'=>'')),$this->node->name);
	    }
      
    } else {
      $this->node=$start_node;
      //$this->id=Auth::instance()->get_user()->start_node;
    }
  }
  
  
  //this lets us run external controllers as sub functions of this controller
  //sometimes something like 
  public function sub(){
        $controller=$this->request->action();
        $action=$this->request->param('subaction');
        
        $route=$this->request->url(array('controller'=>$controller,'action'=>$action));
        $this->template->content = Request::factory( $route )->execute();                              
  }
  
  public function action_style(){
    $this->sub();
  }
  public function action_password(){
    $this->sub();
  }
  public function action_watermark(){
    $this->sub();
  }
  public function action_shopping(){
    $this->sub();
  }
  
  function action_delete(){
    $album=$this->node;
    //Add some sort of user detection
    if ($this->id==Auth::instance()->get_user()->start_node
        || !$album->belongs_to(Auth::instance()->get_user()->start_node)
    ){
      Hint::set(Hint::ERROR,"You do not have permission to delete this item");
      //redirect
      return;
    }
    
    if ($this->request->query('ok')){
        $parent=$album->parent;
        $album->delete_all();
        $this->request->redirect($this->request->uri(array('controller'=>$parent->type,'id'=>$parent->id,'action'=>'')));
      //redirect
    } else {
    Hint::set(Hint::WARNING,"This will delete the album and all child content (images, comments, etc) Are you sure? <a href='?ok=1'>OK</a>" );
    //Are you sure?
    //Dont ask me this again!
    }
  }
  
  function links($id=false){
  //edit
  //delete  if $id!=$start_node
  //
  //upload
  //add section
  }
 
   
 function action_edit(){    
     $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
    
      
      $data=$this->node;
      $columns = Arr::extract($data->list_columns(),$this->_fields);
      $columns['private']=array('formtype'=>'raw','data'=>$this->access());
      
   if($post=$this->request->post()){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($post, $this->_fields);
    
    try {
		$data->save();
		Hint::set(Hint::SUCCESS,"Your record was successfully updated.");
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));}

  	} catch(ORM_Validation_Exception $e) {
  	  $errors=$e->errors('models');
        Hint::set(Hint::ERROR,"You failed to update the record");
  	}  
  } 
 }
  
//  public function access(){
//    $users= ORM::factory('user')->find_all();
//    return View::factory('admin/blocks/access')
//   	  ->bind('users',$users);
//  
//  }
  
  public function action_select(){
    $model=array(
        'select'=>array(
          'formtype'=>'select',
          'options'=>array(),
        )
    );
  
    $item=$this->node;
    //$self = FALSE, $direction = 'ASC', $direct_children_only = FALSE, $leaves_only = FALSE, $limit = FALSE, array $where=array()
    $tree=$item->get_descendants(false,'ASC',False,false,false,array(array('column'=>'published','operator'=>'=','value'=>1)));
    foreach ($tree as $node){
      $model['select']['options'][$node->id]=str_repeat('&nbsp;&nbsp;', $node->level - $item->level-1).$node->name;
    }
    echo Form::render($model);
  }
  
  }
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tree extends Master_Admin {
  protected $_model='album';
  
  public function before(){
    parent::before();
    $this->id=$this->request->param('id');
    if ($this->id){
      $collection=ORM::factory($this->_model,$this->id);
      $start_node=ORM::factory($this->_model,Auth::instance()->get_user()->start_node);
      if ($collection->id!=$start_node->id&&$collection->level<=$start_node->level){
        //return $this->template->content="No Access!!!";
        $this->fof();
      }
    } else {
      //echo Auth::instance()->get_user()->start_node;
      $this->id=Auth::instance()->get_user()->start_node;
    }
  }
  
  public function action_index(){
    //return $this->action_view();  

   // if ($this->request->param('id')) {
   //   $this->request->action('view');
   //   return $this->action_view();  
   // }
    
    $collections=ORM::factory($this->_model)
      ->where('parent_id','=',$this->id)
      ->find_all();
    ;
    
   $this->template->content=View::factory('/admin/blocks/collection')
      ->bind('collection',$collections);
    

  }
  
  public function action_view(){    
      $this->template->content = View::factory('pages/admin/album-details')
        ->bind('album', $collection);
     
  }
  
  
  public function action_add(){
    $data=ORM::factory($this->_model); 
    
    $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
      $fields=array('name', 'desc', 'private','comments','published');
      $columns = Arr::extract($data->list_columns(),$fields);
      
   if($_POST){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($_POST, $fields);
    
    try {
    $data->insert_as_last_child($this->request->param('id'));
		$data->save();
		
		Hint::set(Hint::SUCCESS,"Your record was successfully created.");
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));}

  	} catch(ORM_Validation_Exception $e) {
  	  $errors=$e->errors('models');
        Hint::set(Hint::ERROR,"You failed to create the record");
  	}  
  }
 }
 
 function action_edit(){
   $data=ORM::factory($this->_model,$this->request->param('id'));
   if (!$data->id) return $this->fof();
   
   if ($data->id!=$start_node->id&&$data->level<=$start_node->level){
      return $this->template->content="No Access!!!";
    }
    
     $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
      $fields=array('name', 'desc', 'private','comments','published');
      $columns = Arr::extract($data->list_columns(),$fields);
      
   if($_POST){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($_POST, $fields);
    
    try {
		$data->save();
		
		Hint::set(Hint::SUCCESS,"Your record was successfully created.");
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));}

  	} catch(ORM_Validation_Exception $e) {
  	  $errors=$e->errors('models');
        Hint::set(Hint::ERROR,"You failed to create the record");
  	}  
  } 
 }
  
  public function action_reorder(){
      
      switch($this->request->query('mode')){
       case FALSE:
       break;
       case 'top':
        $item->move_to_first_child($item->parent);
       break;
       case 'up':
        //PREVIOUS-SIBLING get node where right=($this->left-1) and level=$this->level
        //NEXT-SIBLING get node where left=($this->right+1) and level=$this->level
        //SIBLING-POS count(nodes) where left<$this->right and level=$this->level 
        //Sibling-number(3) - select itesm between left and right where level =1 limit 1 offset $pos
        //child-number
        $item->move_to_prev_sibling($item->get_prev_sibling());
       break;
       case 'move':
        if(!$item_id=$this->request->query('item_id')) return;
        $item=Orm::factory($this->_model,$item_id);
        if (!$to=$this->request->query('to')) return;
        $sibling=Arr::get($item->siblings->as_array(),$to - 1,false);
        if (!$sibling){
           $item->move_to_last_child($item->parent);
        } else {
          echo debug::vars($sibling);
          $item->move_to_prev_sibling($sibling);
        }
        break;
        case 'order':
        return;
          
        break;
      default:
        break;
      }  
  }
  
  
  public function action_fix(){
      $item=Orm::factory('tree',1);
      $item->rebuild_tree(1);
      return;
      
      $parent=Orm::factory('tree',26);
      $item->move_to_prev_sibling($parent);

  }
  
  public function action_child(){
  $r=ORM::factory('tree',15);
  echo debug::vars( $r->children); //obj
  return;
  
  echo debug::vars( $r); //obj
  echo debug::vars( $r->parent);//obj
  echo debug::vars( $r->parents);//result 
  echo debug::vars( $r->children);//result 
  echo debug::vars( $r->first_child);//result 
  echo debug::vars( $r->last_child);//result 
  echo debug::vars( $r->siblings);//result 
  echo debug::vars( $r->root);//obj
  echo debug::vars( $r->roots);//result 
  echo debug::vars( $r->leaves);//result 
  echo debug::vars( $r->descendants); //result 
  echo debug::vars( $r->fulltree);    //result 
  }
}
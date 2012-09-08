<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Collection extends Controller_Admin_Album_Core {
public function action_index(){
   $collection=$this->node;
   
   if (!$this->internal && $this->node->type != $this->request->controller()) {
      $this->request->redirect($this->request->url(array('controller'=>$this->node->type)));
   }
   
   //ORM::factory($this->_model,$this->id);
   $children   = $collection->get_descendants(false);
   if (! $children->count()) {
    $empty = "-empty-";
   }
   
   
   $media =  $this->template->content=$this->getView('blocks/collection')//View::factory('/admin/blocks/collection')
      ->bind('collection',$children);
    
   $this->template->content=$this->getView('collection/summary')//View::factory('/admin/collection/summary')
      ->bind('collection',$collection)
      ->bind('media',$media)
      ->bind('empty', $empty);

  }
  
  public function action_cover(){return $this->sub();}
  
  function after(){
  
    if ($this->auto_render) {  
      $view=$this->getView('collection')//View::factory('admin/collection')
         ->set('content',$this->template->content)
         ->set('collection',$this->node);
      $this->template->content = $view;
    }
    
    parent::after();
  }

 
  
  public function action_add(){
    $this->_fields[]='type'; 
    $data=ORM::factory($this->_model); 
    
    $this->template->content = $this->getView('edit')//View::factory('admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
      
      $columns = Arr::extract($data->list_columns(),$this->_fields);
     /*
 foreach (Arr::get($columns['type'],'options',array()) as $key=>$value){
        $columns['type']['options'][$key]=ucwords($value);
      }
*/
      
      
   if($_POST){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($_POST, $this->_fields);
    
    try {
    $data->insert_as_last_child($this->node->id);
		$data->save();
		
		Hint::set(Hint::SUCCESS,"Your record was successfully created.");
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('controller'=>$data->type,'action'=>'','id'=>$data->id)));}

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
       case 'move2':
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
       case 'move':
        //echo 'hello';
        if(!$item_id=$this->request->query('item')) return;
        
        $item=Orm::factory($this->_model,$item_id);
       // if (!$to=$this->request->query('before')) return;
        //$sibling=Arr::get($item->siblings->as_array(),$to - 1,false);
        if ($before=$this->request->query('before')) {
          $item->move_to_next_sibling($before);
        } else {
          $under=$this->request->query('under');
          if (!$under) {$under=$item->parent;}
          
          echo "item->move_to_first_child($under);";
          
          $item->move_to_first_child($under);
        }
       // } else {
       // $before=$this->request->query('before',$this->parent);
       // $item->move_to_next_sibling($before);
       // }
        
       // if (!$before=$this->request->query('before')){
       //    $item->move_to_last_child($item->parent);
       // } else {
          //echo debug::vars($sibling);
       //   $item->move_to_prev_sibling($before);
       // }
        break;
        case 'order':
        return;
          
        break;
      default:
        break;
      }  
  }

}
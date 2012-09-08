<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Domains extends Master_Admin {
  
  public function action_index($edit=false){
    $this->template->content = $this->getView('domains')//View::factory('admin/domains')
        ->bind('domains', $domains)
        ->bind('columns', $columns)
        ->bind('data', $data)
        ->bind('errors', $errors)
        ->bind('edit', $edit);
        
      
    $domains=Orm::factory('domain')->where('user_id','=',$this->user_id)->find_all();
    
    $data=Orm::factory('domain')->where('user_id','=',$this->user_id)->where('id','=',$edit)->find();
    $columns=$data->list_columns();
    
    if($post=$this->request->post()){
      $data->values($post,array('name','node_id','theme_id','published'));
      if (!$edit){
        $data->set('user_id',$this->user_id);
      }   
      try{
         $data->save();
         Hint::set(Hint::SUCCESS,"You updated the record");
         $this->request->redirect($this->request->url(array('id'=>'','action'=>'')));
      }catch(ORM_Validation_Exception $e) {
  	    $errors=$e->errors('models');
        Hint::set(Hint::ERROR,"You failed to update the record");
      }
      
    }
   //We could check that the domain resoves to this server
  }
  
  
  
  public function action_edit(){
    $this->action_index($this->request->param('id'));
  }
}
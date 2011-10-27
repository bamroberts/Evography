<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Album_Password extends Master_Admin {
  function action_index(){
    $this->template->content=View::factory('admin/password')
      ->bind('password',$record)
      ->bind('album',$album)
      ->bind('current',$current)
      ->bind('users',$users)
      ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors)
      ;
    
    $columns=array('phrase'=>array(),'screenshot'=>array(),);
    
    $album=ORM::factory('album',$this->id);
    $users= ORM::factory('user')->find_all(); //we actually need to find user under this account  -  not sure best way to do this right now
    //add auth
    
    $record=$album->password;
    if ($album->id != $record->id) {
      $current='inherit';
    } else {
      $data=$record;
      $current=($record->active)?'on':'off';
    }
    
    if (  !$album->id
           // || // or is node user start node or a child of?
            //($collection->id!=$start_node->id&&$collection->level<=$start_node->level)
            //if collection is before or after start node it is out of user scope.
           // ($album->lft < $start_node->lft || $album->rgt > $start_node->rgt)
          )
        {
          $this->fof();
        }

  
    if ( $post=$this->request->initial()->post() ){
      switch (Arr::get($post,'current')) {
      case 'inherit':
        if ($record->loaded()){
          $current='inherit';
          if ($album->id==$record->id) {
            $record->delete();
          }
        }
      break;
      case 'off':
        if ($album->id!=$record->id) {
          $record=ORM::factory('album_password');
          $record->id=$album->id;
        }
        $current='off';
        $record->active='0';
        $record->save();
      break;  
      case 'on':
        if ($album->id!=$record->id) {
          $record=ORM::factory('album_password');
          $record->id=$album->id;
        }
        $record->phrase=Arr::get($post,'phrase');
        $record->user_ids=join(Arr::get($post,'users',array()),',');
        $record->active=($record->phrase!='' OR $record->user_ids != '')?true:false;        
        $current=$record->active?'on':'off';
        $record->save();
      break;
      }
    }
  }
}
        

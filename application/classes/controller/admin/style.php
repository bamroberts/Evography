<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Style extends Master_Admin {
  var $options=array(
      'size'=>array(
         'name'=>'Thumbnail size',
         'formtype'=>'select',
         'options'=>array('Big - 200px','Medium - 100px','Small - 50px'),
      ),
      'limit'=>array(
        'name'=>'Items per page',
        'help'=>'User zero for all images',
      ),
      'action'=>array(
        'name'=>'Click action',
        'formtype'=>'select',
        'options'=>array('Image info page','Fill area','Lightbox','slideshow')
      ),
      'height'=>array(
        'name'=>'Page height',
        'help'=>'Height of "desk" area (100 - 1000) in pixels',
      ),
      'animated'=>array(
        'name'=>'Animations',
        'formtype'=>'checkbox',
        'help'=>'Are the images animated',
      ),
      'shuffle'=>array(
        'name'=>'Movable images',
        'formtype'=>'checkbox',
        'help'=>'Can the user shuffle the images',
      ),
      'scroll'=>array(
        'name'=>'Endless album',
        'formtype'=>'checkbox',
        'help'=>'Tick this to have the next images automatically load at the end of page',
      ),
      'polaroid_ajax'=>array(
        'name'=>'Ajax',
        'formtype'=>'checkbox',
        'help'=>'Have the new images fly-in when changing pages (as opposed to a new page)',
      ),      
  );

  function action_index(){
    $this->template->content=View::factory('admin/style')
      ->bind('styles',$styles)
      ->bind('options',$this->options)
      ->bind('album',$album)
      ->bind('columns',$columns)
      ->bind('data', $post)
      ->bind('errors', $errors);
    
    $album = ORM::factory('album',$this->id);
    $styles= ORM::factory('styles')->where('type','=',$album->type)->find_all();
   // foreach ($styles as $style){
   //   $options = explode(',',$style->options); 
   //   $style->options=array();
   //   foreach ($options as $option){
   //   $option=trim($option);
   //   $style->options["{$style->name}_{$option}"]=Arr::get($this->options,$option,false);
      
   //   } 
   // }
    
    //auth    
    $start_node=ORM::factory('album',$this->start_node);
    if (  !$album->id
            || 
          ($album->lft < $start_node->lft || $album->rgt > $start_node->rgt)
        )
        {
          $this->fof();
        }

    
   if ($post=$this->request->post()){
       $values['style_id']=$post['style'];
       foreach ($this->options as $option){
         if ($value=Arr::get($post,"style_{$post['style']}_{$option}",false)) {
          $values[$option]=$value;
         }  
       }
       $album->values($values);
       $album->save();
   }
  
    }
}
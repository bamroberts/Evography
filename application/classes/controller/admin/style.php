<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Style extends Controller_Admin_Album_core {
  var $options=array(
      'size'=>array(
         'label'=>'Thumbnail size',
         'formtype'=>'select',
         'options'=>array('Big - 200px','Medium - 100px','Small - 50px'),
      ),
      'limit'=>array(
        'label'=>'Items per page',
        'help'=>'User zero for all images',
        'value'=>'A million',
      ),
      'action'=>array(
        'label'=>'Click action',
        'formtype'=>'select',
        'options'=>array('Image info page','Fill area','Lightbox','slideshow')
      ),
      'height'=>array(
        'label'=>'Page height',
        'help'=>'Height of "desk" area (100 - 1000) in pixels',
      ),
      'animated'=>array(
        'label'=>'Animations',
        'formtype'=>'checkbox',
        'help'=>'Are the images animated',
      ),
      'shuffle'=>array(
        'label'=>'Movable images',
        'formtype'=>'checkbox',
        'attr'=>array(
          'placeholder'=>'Can the user shuffle the images',
        ),
        'placeholder'=>'Can the user shuffle the images',

        
      ),
      'scroll'=>array(
        'label'=>'Endless album',
        'formtype'=>'checkbox',
        'help'=>'Tick this to have the next images automatically load at the end of page',
      ),
      'polaroid_ajax'=>array(
        'label'=>'Ajax',
        'formtype'=>'checkbox',
        'help'=>'Have the new images fly-in when changing pages (as opposed to a new page)',
      ),      
  );

  function action_index(){
    $this->template->content=$this->getView('style')//View::factory('admin/style')
      ->bind('styles',$styles)
      ->bind('options',$this->options)
      ->bind('album',$album)
      ->bind('form',$form)
      //->bind('columns',$columns)
      //->bind('data', $post)
      ->bind('errors', $errors);
      
          
    $album = $this->node;
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
    
   if ( ($post=$this->request->initial()->post()) && ($style=Arr::get($post,'style'))){
       $album->set('style_id',$style);
       $data=Arr::get($post,"style_{$style}");
       foreach ($this->options as $name=>$option){
         if ($value=Arr::get($data,$name)) {
          //$album->set($name,$value);
         }  
       }
       $album->save();
   }
   
    $form=Formo::form();
    foreach ($styles as $style){
      $options=explode(',',$style->options);
      $columns=Arr::extract($this->options,$options);
      $sub = Formo::form();
      foreach ($columns as $name=>$details){
        $item=$sub->add($name,Arr::get($details,'formtype'),$details);
        if ($style->id==4 && $name=='limit') $sub->error($name,'not a good thing!');
      }
      
      $form->add("style_{$style->id}", 'group', $sub, array('label'=>false));
      
     // die();
     // $form[$style->id]=$sub;//Form::factory($columns,$post,$errors,array('prefix'=>"style_{$style->id}"));
    }
    
    

 // $form= Form::factory($columns,$post,$errors);

    }
}
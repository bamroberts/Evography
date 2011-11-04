<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Watermark extends Controller_Admin_Album_core {
  function action_index(){
    $this->template->content=View::factory('admin/watermark')
      ->bind('watermark',$record)
      ->bind('default',$default)
      ->bind('current',$current)
      ->bind('start_node',$this->start_node)
      ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
    
    $start_node=ORM::factory('album',$this->start_node);
    $album=$this->node;
    if (  !$album->id
            || // or is node user start node or a child of?
            //($collection->id!=$start_node->id&&$collection->level<=$start_node->level)
            //if collection is before or after start node it is out of user scope.
            ($album->lft < $start_node->lft || $album->rgt > $start_node->rgt)
          )
        {
          $this->fof();
        }

  
    $record=$album->watermark;
    $default=$start_node->watermark;
    
    
   
    
    
    if (!$record->id) 
    {   
      $current='default';
      //$record->clear();
      $record->id=$this->id;  
    } 
    else 
    {
      $current=$record->active?'on':'off';
    }
    
    $columns = $record->list_columns();
    
    if ($post=$this->request->initial()->post()){
      if (!empty($_FILES)&&$path=$this->upload()) {$record->path=$path;}
    //upload image regard less
      switch (Arr::get($post,'current')) {
      case 'default':
        if ($record->loaded()){
          $current='default';
          $record->delete();
          $this->flushcache();
        }
      break;
      case 'off':
        $current='off';
        $record->active='0';
       // if (!empty($record->_changed)){
          $record->save();
          $this->flushcache();
       // }
      break;  
      case 'on':
        $record->position=$post['position'];
        //if ($path) $record->path=$path;
        $record->active=$record->path && $post['current']=='on'?'1':'0'; 
        if (is_numeric($post['opacity']) || $post['opacity'] <= 100 || $post['opacity'] >= 10 ) {$record->opacity=$post['opacity'];}
        //if (!empty($record->_changed)){
          $current=$record->active?'on':'off';
          $record->save();
          $this->flushcache();
        //}
      break;
      }
       
    }
    
  }
  
  function upload(){
   $targetDir= "images/uploads/{$this->user_id}/watermarks/";
      if (!file_exists(DOCROOT.$targetDir))
  	     @mkdir(DOCROOT.$targetDir);
    $files = new Validation($_FILES);
    $files->rules(
        'path',
        array(
            array('Upload::not_empty', NULL),
            array('Upload::valid' , NULL),
            array('Upload::size', array(':value','20M')),
            array('Upload::type' , array(
                ':value',
                array('jpg', 'png', 'gif', 'jpeg')
            )),
        )
    );
    $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES['path']['name'];
    $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
  
  	$ext = strrpos($fileName, '.');
  	$fileName_a = substr($fileName, 0, $ext);
  	$fileName_b = substr($fileName, $ext);
  
  	$count = 1;
  	while (file_exists(DOCROOT.$targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
  		$count++;
  	$fileName = $fileName_a . '_' . $count . $fileName_b;
  
    
  	
  	if ($files->check())
    {
     
      // Upload is valid, save it
      $path = Upload::save($files['path'],$fileName,DOCROOT.$targetDir);
      $image = Image::factory($path);
      if ($image->width>=400 || $image->height>=400){
        $image->resize(400, 400, Image::AUTO);
        $image->save();
        //set flash "Your watermark image should not be larger than 400px in either dimention. We have resized it for you";
      }
      return $targetDir.DIRECTORY_SEPARATOR.$fileName;
    }	else {
      return false; 
    }
  }
 
 function flushcache(){
      $id=$this->id; 
      // If the watermark has changed we need to make sure that all images that 
      // could potentially be affected are wiped from the image cache.
      // 
      // We do this by caching the old paths, seting new unique id's then deleteing the old cache paths.
      // The scary looking sql statement make sure we get all child albums and images not just the one we are editing.
      // Because we are just wiping the cache it doesn;t matter if child albums over ride these settings further down.
      
      $sql="
        SELECT filehash 
        FROM images
        WHERE album_id in (
          SELECT id 
          FROM album_tree 
          WHERE lft>=(
              SELECT lft 
              FROM album_tree 
              WHERE id='$id'
          ) 
          AND   rgt<=(
              SELECT rgt 
              FROM album_tree 
              WHERE id='$id'
          )
      )
      ";
      //cache the old values
      
      $query=DB::query(Database::SELECT,$sql);
      $results= $query->as_object()->execute();

      //set the new ones
      $sql="
       UPDATE images 
       SET filehash=UUID() 
       WHERE album_id in (
          SELECT id 
          FROM album_tree 
          WHERE lft>=(
              SELECT lft 
              FROM album_tree 
              WHERE id='$id'
          ) 
          AND   rgt<=(
              SELECT rgt 
              FROM album_tree 
              WHERE id='$id'
          )
      )"; 
      DB::query(Database::UPDATE,$sql)->execute();
      
      //delete the old files now we know they wont be needed anymore.
      foreach ($results as $image){
        File::destroy_directory("images/dynamic/".$image->filehash,true);
      }
  }
}
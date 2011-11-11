<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tags extends Controller_Admin_Album_core {

function action_index(){
    $album=$this->node;
}

function action_add(){
  //$image=ORM::factory('image',$id);
  //$image->add('image_tags',$tag)
  //$image_tag= ORM::factory('image')->where('image_id');
  
  
}

function action_delete(){}

function action_suggest(){}
  //$sql="SELECT image_id FROM image_tags where tag='$'";
  
  //select all images with matching tags
  
  //select all tags, count(*) with ^ ids excluding tags already selected order by count()
  
  
}
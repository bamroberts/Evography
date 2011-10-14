<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Multiview extends Controller_Admin_Album {
	
	public $fields=array('name', 'desc', 'type', 'private','published');
	
	
	function action_index(){
  	//Check page exists and is of right type
  	
  	$id=$this->request->param('id');
  	$album=ORM::factory('album',$id);
  	
  	if ($album->type!='multiview'){
  	  $this->fof();
  	}
  	
  	$section=array();
  	$children=$album->children->find_all();
  	foreach ($children as $child){
  	  $section[]=View::factory('/admin/blocks/multipage-section')
  	    ->set('details', $child);
  	}
  	
  	$this->template->content=View::factory('/admin/multipage')
  	    ->bind('details', $album)
  	    ->bind('sections',$section)
  	    ;
	  }
	
	function action_new_section(){
    $this->id = $this->request->param('id');
	  $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $album)
      ->bind('errors', $errors);
      
      $album = ORM::factory('album');
      $columns = Arr::extract($album->list_columns(),$this->fields);
      
    if($post=$this->request->post()){        
      try {
        $album->values($post, $this->fields)
            ->set('parent_id',$this->id)
            ->set('user_id',$this->user_id)
            ;

		    $album->save();
		    Hint::set(Hint::SUCCESS,"You added a new {$album->type} section.");
		    $this->request->redirect($this->request->uri(array('action'=>'','id'=>$this->id)));
      
      } catch(ORM_Validation_Exception $e) {
	       $errors=$e->errors('models');
         Hint::set(Hint::ERROR,"There are errors that need correcting");
	    }
    }
	}
	
	function action_options(){
	  
	
	}
	
	public function action_organise(){
  	$album=ORM::factory( 'album', $this->request->param('id') );
  	$count=$album->images->count_all();
  	
  	
  	$fix=$album->images->where('order','<','1')->count_all();
  	if ($fix) {
  		$order=1;
  		foreach ($images as $image) {
  		  $image->set('order',$order++);
  		  $image->save();
  		}	
  	}
  	
  	$this->template->content = View::factory('pages/admin/organise')
			->bind('images', $images);
	//actions		
  	if ($_REQUEST) {
  	  Switch ($_REQUEST['mode']){
  	  	CASE 'swap':
  	  	  $a=ORM::factory('image',$_REQUEST['a']);
  	  	  $b=ORM::factory('image',$_REQUEST['b']);
  	  	  
  	  	  $temp=$a->order;
  	  	  
  	  	  $a->set('order',$b->order);
  	  	  $a->save();
  	  	  
  	  	  $b->set('order',$temp);
  	  	  $b->save();
  	  	  
  	  	  //$this->request->redirect(Request::current()->uri());
  	  	break;	
  	  	CASE 'sort':
  	  	  $array=explode(',',Arr::get($_REQUEST,'order',false));
  	  	  if (!is_array($array)) return;
  	  	    $sql="INSERT INTO `images` (`id`,`order`) VALUES ";
  	  	    foreach ($array as $order=>$id) {
  	  	      if ($id){
  	  	        $sql.="($id,$order), " ;
  	  	      }
  	  	    }
  	  	    $sql=trim($sql,', ')." ON DUPLICATE KEY UPDATE `order`=VALUES(`order`);";
            DB::query(Database::INSERT, $sql, FALSE)->execute();
            //echo $sql; return;
  	  	break;
  	    DEFAULT;
  	  	}
  	  	
  	  	if ($this->request->initial()->is_ajax() || Arr::get($_GET,'ajax',false)) {
          $this->json['status']='New order saved';
          return;
        }
  	  	$this->request->redirect($this->request->uri());
  	}
  	
  }
}
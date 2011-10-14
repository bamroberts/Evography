<?php 
  class Controller_Admin_Upload extends Controller_AdminTemplate {
  	
  	function action_index(){
  	  $this->template->content = View::factory('pages/admin/upload')
      ->bind('results', $results)
      ->bind('page_links', $page_links);
  	}
  	
  	function action_save(){  
  	if (!$_FILES) return;
  	$files = new Validation($_FILES);
            $files->rules(
                'Filedata',
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
   if($files->check()) {
         //if passed checks save imag in new home 
            $user_id=Auth::instance()->get_user();
            $album_id=$this->request->param('id');
            $album_id=1;
			$path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
			if (!is_dir($path)) {
			  mkdir($path,0777,true);
			}
			
			$file=pathinfo($_FILES['Filedata']['name']);	
			$filename     =$file['basename'];
			$name		  =$file['filename'];	
			$ext          =strtolower($file['extension']);
			
			$hash         =uniqid();
			
			$new_filename ="{$hash}.{$ext}";
			
			$filepath=Upload::save($_FILES['Filedata'], $new_filename, $path, 0777);
		    $size         =filesize($filepath);
			list($width,$height) = @getimagesize($filepath);
		//STORE IMAGE IN DB	
		//Get filename and path parts	
		 
		 //Get exif photodata
		  $meta=exif_read_data($filepath);
			  $camdata["Make"]        =Arr::get($meta, 'Make');
			  $camdata["Model"]       =Arr::get($meta, 'Model');
			  $camdata["Aperture"]    =Arr::get(Arr::get($meta, 'COMPUTED'), 'ApertureFNumber');
			  $camdata["Exposure"]    =Arr::get($meta, 'ExposureTime');
			  $camdata["ISO"]         =Arr::get($meta, 'ISOSpeedRatings');
			  $camdata["Orientation"] =Arr::get($meta, 'Orientation')==1?'Landscape':'Portrait';
			  $camdata["Lens"]  	  =Arr::get($meta, 'UndefinedTag:0x0095');
			  $camdata["Focal Length"]=Arr::get(Arr::get($meta, 'UndefinedTag:0x0002'), 1);
		  $record["meta"]=serialize($camdata);
		 
		  $record["filehash"] =$hash;
		  $record["filename"] =$filename;
		  $record["path"]     =str_replace('\\','/',str_replace(DOCROOT,'',$filepath)); 

		  $record["width"]    =$width;
		  $record["height"]   =$height;
		  
		  $record["size"]     =$size;
		  
		  $record["ext"]      =$ext;
		  $record["taken"]    =date('Y-m-d H:i:s',time(Arr::get($meta, 'DateTime')));
		  $record["name"] 	  =$name;
		  $record["active"]   =1;
		  
		  $record["add_user_id"]= $user_id;
		  $record["mod_user_id"]= $user_id;
		  $record["add_date"]= date('Y-m-d H:i:s');
		  $record["mod_date"]= date('Y-m-d H:i:s');
		  $record["album_id"]= $album_id;
		  $record['order']= ORM::factory('album',$album_id)->images->order_by('order','DESC')->find()->order + 1;
		  
		  $image=ORM::factory('image');
	      $image->values($record);
	      $image->check();
	      $image->save();
	      $image->add('albums', $album_id);

		  $return=$image->as_array();	
		  $return['status']=1;
		  
   } else {	 
		    $return = array(
			 'status' => '0',
			 'error' => "Upload and server side validation failed"
			);
   }
	
   if ($this->request->is_ajax() || Request::$user_agent=='Adobe Flash Player 10') {
      	    $this->auto_render = FALSE;
            $this->is_ajax = TRUE;
            header('content-type: application/json');
            $this->response->body( json_encode($return) );
    }
     
    $this->template->body="<pre>".print_r($return,true)."</pre>"; 
      
  }
}
  	
  	
  	 
  
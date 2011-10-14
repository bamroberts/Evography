<?php 
defined('SYSPATH') or die('No direct script access.');
 class Helpers // Form extends Kohana_form
  {
  	static function render_form ($column_data,$data=array(),$errors=array(),$fields=NULL){
  	  $columns=$column_data;
  	  //Cols for single field i.e. $fields='username';
  	  if (is_string($fields)) {
  	  	$columns=Arr::extract($column_data, array($fields));
  	  }	
  	  //Cols for multiple non-associated array i.e. $fields=array('username');
  	  if (is_array($fields) && !Arr::is_assoc($fields)) {
  	  	$columns=Arr::extract($column_data, $fields);
  	  }
  	  //Cols for multiple associated array i.e. $fields=array('username'=>'some other data');
  	  if (is_array($fields) && Arr::is_assoc($fields)) {
  	  	$columns=Arr::extract($column_data, array_keys($fields));
  	  }
  	  
  	  $response='';
  	  foreach ($columns as $col=>$details) {
  	    $d       ='';
  	    $formtype=Arr::get($details,'formtype','text');
  	    if (is_object($data)) $data=  $data->as_array();
  	    $label="<label for=\"$col\" >" . Arr::get($details,'name',ucwords($col))."</label>";
  	    $value   =Arr::get($data,$col,false);
		switch ($formtype) {
			case 'hidden' :
			  $label=false;
			  $d.=Form::hidden($col, $value,array('id'=>$col));
			  break;
		  case 'text' :
			  $d.=Form::input($col, $value,array('id'=>$col));
			  break;
		  case 'password' :
		    $formtype='text password';
			  $d.=Form::password($col, $value,array('id'=>$col));
			  break;
			case 'textarea':
			  $d.=Form::textarea($col, $value,array('id'=>$col));
			break;
			case 'checkbox':
			  $d.=Form::hidden($col, 0,array('style'=>'display:none;'));
			  $d.=Form::checkbox($col, 1, $value==1?true:false,array('id'=>$col));
			break;
			case 'enum':
			case 'radio':
			  if ( is_array( $radio=Arr::get($details,'options',array() ) ) ) {
			      $d.="<ul>";
				  foreach ($radio as $key=>$text) {
				    $d.="<li>";
				    $d.=Form::radio($col, $key, $value==$key?true:false,array('id'=>"{$col}_{$key}"));
					$d.="<label for=\"{$col}_{$key}\">$text</label>";
					$d.="</li>";
				  }
				  $d.="</ul>";
			  }
			break;
			case 'select':
			case 'select_data':
  			if ( is_array( $select=Arr::get($details,'options',array() ) ) ) {
  			  $d.=Form::select($col, $select, $value, array('id'=>$col) );
  		  }
		  break;
		  case 'image_pick':
		    //set as radio
		  case 'image_select':
		   if ( is_array( $options=Arr::get($details,'options',array() ) ) ) {
			      $d.="<ul id='$col'>";
			      foreach ($options as $id=>$src) {
			        $d.="<li>";
			        $d.="<label for=\"{$col}_{$id}\"><img src=\"$src\" alt=\"Image $id\" /></label>";
		          //$d.=Form::hidden($col.'[]', 0,array('style'=>'display:none;'));
			        $d.=Form::checkbox($col."[$id]", 1, $value==1?true:false,array('id'=>"{$col}_{$id}"));
			        $d.="</li>";
			      }
			      $d.="</ul>";
			 }
		  break;
		  case 'all':
		     if ($from=Arr::get($details,'from',false))  {
		        $field=Arr::get($column_data,$from,array());
		        $options=Arr::get($field,'options',array());
		        foreach ($options as $id=>$src) {
		          $d.=Form::hidden($from."[$id]", 1,array('style'=>'display:none;'));
		        }
		      }
		  break;
		}
  	  
  	  if ($error=Arr::get($errors, $col)){
  //echo  	  Helpers::print_r(Arr::get($errors, $col));
  	  		$d.="<p>$error</p>";
  	  		$error="error";
  	  		}
  	  $response.="
  	    <div class=\"input $formtype $error\">
  	    	$label
  	    	$d
  	    </div>
  	  ";
  	  }
  	  return $response;
  	  //return "<fieldset>$response</fieldset>";
  	}
  	
  	static function url($route_details=array(),$query=false){
  	 $url=Request::current()->uri($route_details);	       			
  	 if ($query) $query=URL::query($query);
  	 return URL::site($url.$query);
  	}
  	
  	static function print_r ($data) {
  	  return "<pre>".print_r($data,true)."</pre>";
  	}
  }
<?php 
defined('SYSPATH') or die('No direct script access.');
 class Form extends Kohana_form
  {
  	static function render ($column_data,$data=array(),$errors=array(),$fields=NULL,$prefix=null){
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
  	  if ($prefix) $col=$prefix.$col;
  	    $d       ='';
  	    $formtype=Arr::get($details,'formtype','text');
  	    if (is_object($data)) $data=  $data->as_array();
  	    $label="<label for=\"$col\" >" . Arr::get($details,'name',ucwords($col))."</label>";
  	    $value   =Arr::get($data,$col,Arr::get($details,'default',false));
		switch ($formtype) {
			case 'plain' :
			  $d.=Form::hidden($col, $value,array('id'=>$col));
			  $d.="<p>$value</p>";
			  break;
			case 'hidden' :
			  $label=false;
			  $d.=Form::hidden($col, $value,array('id'=>$col));
			  break;
		  case 'text' :
			  $d.=Form::input($col, $value,array('id'=>$col));
			  break;
		  case 'password' :
		    $formtype='text password';
			  $d.=Form::password($col, false, array('id'=>$col));
			  break;
			case 'textarea':
			  $d.=Form::textarea($col, $value,array('id'=>$col));
			break;
			case 'checkbox':
			  $d.=Form::hidden($col, 0,array('style'=>'display:none;'));
			  $d.=Form::checkbox($col, 1, $value==1?true:false,array('id'=>$col));
			  if ($helper=Arr::get($details,'helper',false)) {
			   $d.="<label for='$col' class='helper'>$helper</label>";
			  }
			break;
			case 'enum':
			  $formtype="enum radio";
			case 'radio':
			  if ( is_array( $radio=Arr::get($details,'options',array() ) ) ) {
			      $d.="<ul>";
				  foreach ($radio as $key=>$text) {
				    if ($formtype == 'enum radio') {$key=$text;}
				    $d.="<li>";
				    $d.=Form::radio($col, $key, $value==$key?true:false,array('id'=>"{$col}_{$key}"));
					$d.="<label for=\"{$col}_{$key}\">$text</label>";
					$d.="</li>";
				  }
				  $d.="</ul>";
			  }
			break;
			case 'db_tree_select':
			  $tree=true;
			case 'db_select':
			  if (!Arr::get($details,'options',false) && $model=Arr::get($details,'model',false) && $function=Arr::get($details,'function',false)){
  			  $data=Orm::factory($details['model'])->{$details['function']}();
  			  foreach ($data as $r){
  			    $spacer=isset($tree)?str_repeat('&nbsp;&nbsp;',$r->level):'';
  			    $details['options'][$r->id]=$spacer.$r->name;
  			  }
  		  }
			case 'select_data':
			    if (!Arr::get($details,'options',false) && Arr::get($details,'model',false) && $function=Arr::get($details,'function',false)){
			      $details['options']=Orm::factory(Arr::get($details,'model',false))->{$function}();
			    }
			case 'select enum':
			     foreach (Arr::get($details,'options',array()) as $option){
			       $opt[$option]=$option;
			     }
			     $details['options']=$opt;
			case 'select':
  			if ( is_array( $select=Arr::get($details,'options',array() ) ) ) {
  			  $d.=Form::select($col, $select, $value, array('id'=>$col) );
  		  }
		  break;
		  case 'file':
		      $d.=Form::file($col,array('id'=>$col));
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
		  case 'raw':
		    $label=false;
		    $d=Arr::get($details,'data',false);
		  break;
		}
  	  $h=Arr::get($details,'help',false);
  	  if ($error=Arr::get($errors, $col)){
  //echo  	  Helpers::print_r(Arr::get($errors, $col));
  	  		$h="<p>$error</p>";
  	  		$error="error";
  	  		}
  	  $response.="
  	    <div class=\"group $formtype input_{$formtype}_{$col} $error\">
  	    	$label
  	    	$d
  	    	$h
  	    </div>
  	  ";
  	  }
  	  return $response;
  	  //return "<fieldset>$response</fieldset>";
  	}
  	
  	static function render2($content) {

  	
  	}
}
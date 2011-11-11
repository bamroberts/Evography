<?php 
defined('SYSPATH') or die('No direct script access.');
 class Form extends Kohana_form
  {
  	static function render2 ($column_data,$data=array(),$errors=array(),$fields=NULL,$prefix=null){
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
  	
  
  	
  	static function render ($column_data,$values=array(),$errors=array(),$fields=NULL,$prefix=null){
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
  	  if (is_object($values)) $values=  $values->as_array();
  	   	  
  	  $items=array();
  	  foreach ($columns as $name=>$settings) {
  	   if (!is_array($settings)) {$settings=array();}
  	   $details=Arr::merge(Form::defaults(),$settings);
  	   $details['value']=Arr::get($values,$name,Arr::get($details,'default'));
  	   if ($error=Arr::get($errors,$name)){
  	     $details['error'] = 'error';
  	     $details['help'] = $error;
  	   }
  	   
  	 // if (is_array($control=$details['control'])) {
  	 //   $details['control']="";
  	 //    foreach ($control as $data=>$config){
  	 //      $details['control']
  	//     }
  	//   }
  	   
  	   
  	   //really this should be lable, but some old models use name;
       if (!$details['label']) {$details['label']=Arr::get($details,'name',ucwords($name));}
       $details['name']=$name;
  	   
       if ($prefix) $name=$prefix.$name;
        //print_r($details); die();
        
         $details['type']=$details['formtype'];
  	   switch($type=$details['type']){
  	    //rendered without wrapper
    		  case 'hidden' :
    			  $items[]=Form::hidden($col, $value,array('id'=>$col));
    			  continue;
    		  break;
    			case 'raw':
    		    $items[]=Arr::get($details,'data',false);
    		    continue;
    		  break; 
    		 
    		 //Basic types  
    			case 'plain' :
    			  $content=Form::hidden($name, $details['value'], array('id'=>$name))
    			           ."<p>{$details['value']}</p>";
    			  break;
    		  
    		  case 'text' :
    		  case 'password' :
    			case 'textarea':
    			case 'radio':
    			 $content=View::factory("form/$type")->set($details);
    			break;
    				
    			case 'enum':
    			  $details['type']='radio radio-emum';
    			  foreach(Arr::get($details,'options',array()) as $key=>$value){
    			    $details['options'][$value]=$value;
    			    unset($details['options'][$key]);
    			  }
    			  $content=View::factory("form/radio")->set($details);
    			break; 
    			  
    			
    			case 'checkbox': 
    			case 'checkbox-group':
    			  $details['type']='checkbox';
    			  $content=View::factory("form/checkbox")->set($details);
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
    			case 'select_enum':
    			     foreach (Arr::get($details,'options',array()) as $option){
    			       $opt[$option]=$option;
    			     }
    			     $details['options']=$opt;
    		  
    		  $details['type']="select {$details['type']}";
    			case 'select':
      		  $content=View::factory("form/select")->set($details);
    		  break;
    		  
    		  //Files - to inc js-plupload
    		  case 'multiple_file':
    		  case 'file':
    		      $this->multipart=true;
    		      $content=View::factory("form/file")->set($details);
    		  break;
    		  
    		  //for images selction - import / export etc
    		  case 'image_radio':
    		  case 'image_chackbox':  
    		  case 'image_select':
    		    $content=View::factory("form/image-picker")->set($details);
    		  break;		  
    		  }
  	   
  	   
  	   $items[]= View::factory("form/wrapper")->set($details)->set('content',$content);
  	   
  	  }
  	  
  	  return join($items);
  	}
  	
  	
 static function defaults(){
  return array(
    'name'          => false
  , 'label'         => false
  , 'value'         => false 
  , 'error'         => false 
  , 'formtype'          => 'text'
  , 'help'          => ''
  , 'placeholder'   => false
  , 'options'       => array()
  , 'addon'         => false
  , 'addon_content' => ''
  , 'control'       => false
  , 'blank'         => false //blank option for select - can be set true or have text
  
  );
}



protected $columns, $values, $errors, $default;


static function factory($columns,$values=array(),$errors=array(),$options=array()){
   
    return New Form($columns,$values,$errors,$options); 
}

public function __construct($columns,$values=array(),$errors=array(),$options=array()){
    $this->default=Arr::merge(Form::defaults(),$options);
    $this->columns=$columns;
    $this->values=$values;
    $this->errors=$errors;
        
}

function __tostring(){
  $fields=$this->fields();
  return $this->open()
        .$fields
        .$this->close();
}

function __get($field){
  return $this->render_field($field);
}

function __set($field,$value){
  $this->columns[$field]['value']=$value;
}

function fields($first=null){
  $data=array();

  if (is_array($first))
  {
  $fields=$first;
  } 
  
  elseif (! count( $fields=func_get_args() ) ) 
  {
    $fields=array_keys($this->columns);
  }
  
//echo debug::vars($fields);die();;
  
  foreach ($fields as $field){
    $data[]=$this->render_field($field);
  }
  
  return join($data);
}

function header($multipart) {
  $path=Arr::get($this->default,'path',$this->initial()->url());
  $method=Arr::get($this->default,'method','post');
  $fieldset=Arr::get($this->default,'fieldset')?'<fieldset>':false;
  $enctype=$multipart || $this->multipart || (!isset($multipart) && Arr::get($this->default,'multipart'))?'enctype="multipart/form-data"':'';
  return "<form method='$method' action='$action' $enctype>
          $fieldset";
}
function footer(){ 
  $fieldset=Arr::get($this->default,'fieldset')?'</fieldset>':false;
  return "$fieldset 
          </form>";
}
//function render(){}
function value($field){}
function fieldset($value){
  $this->fieldset=$value;
  return "<fieldset>$value</fieldset>";
}

function setting($key,$value=false) {
  if ($value) {
    $this->defualt[$key]=$value;
  }
  return $this->defualt[$key];
}

function name_space($name,$space){
  if ($space || $space=Arr::get($this->default,$namespace)){
    $name="$space[$name]";
  }
  return $name;
}

function render_field($name){
     //echo debug::vars($name);die();
      
      if (!is_array($settings=$this->columns[$name])){$settings=array();}
      
     // $settings=is_array($=$this->columns[$name];
      
      
  	 // $columns=$column_data;
  	  //Cols for single field i.e. $fields='username';
  	 // if (is_string($fields)) {
  	//  	$columns=Arr::extract($column_data, array($fields));
  	//  }	
  	  //Cols for multiple non-associated array i.e. $fields=array('username');
  //	  if (is_array($fields) && !Arr::is_assoc($fields)) {
 // 	  	$columns=Arr::extract($column_data, $fields);
  //	  }
  	  //Cols for multiple associated array i.e. $fields=array('username'=>'some other data');
  //	  if (is_array($fields) && Arr::is_assoc($fields)) {
 // 	  	$columns=Arr::extract($column_data, array_keys($fields));
  //	  }
 // 	  if (is_object($values)) $values=  $values->as_array();
  	   	  
  //	  $items=array();
 // 	  foreach ($columns as $name=>$settings) {
//  	   if (!is_array($settings)) {$settings=array();}
      

  	   $details=Arr::merge($this->default,$settings);
  	   $details['value']=Arr::get($this->values,$name,Arr::get($details,'default'));
  	   if ($error=Arr::get($this->errors,$name)){
  	     $details['error'] = 'error';
  	     $details['help'] = $error;
  	   }
  	   
  	 // if (is_array($control=$details['control'])) {
  	 //   $details['control']="";
  	 //    foreach ($control as $data=>$config){
  	 //      $details['control']
  	//     }
  	//   }
  	   
  	   
  	   //really this should be lable, but some old models use name;
       if (!$details['label']) {$details['label']=Arr::get($details,'name',ucwords($name));}
       $details['name']=$name;
  	   
       if ($prefix=Arr::get($details,'prefix')) {$name=$prefix.$name;}
        //print_r($details); die();
        
         $details['type']=$details['formtype'];
  	   switch($type=$details['type']){
  	    //rendered without wrapper
    		  case 'hidden' :
    			  return Form::hidden($col, $value,array('id'=>$col));
    			  continue;
    		  break;
    			case 'raw':
    		    return Arr::get($details,'data',false);
    		    continue;
    		  break; 
    		 
    		 //Basic types  
    			case 'plain' :
    			  $content=Form::hidden($name, $details['value'], array('id'=>$name))
    			           ."<p>{$details['value']}</p>";
    			  break;
    		  
    		  case 'text' :
    		  case 'password' :
    			case 'textarea':
    			case 'radio':
    			 $content=View::factory("form/$type")->set($details);
    			break;
    				
    			case 'enum':
    			  $details['type']='radio radio-emum';
    			  $content=View::factory("form/radio")->set($details);
    			break; 
    			  
    			
    			case 'checkbox-group':
    			  //set namespace;
    			case 'checkbox': 
    			  $details['type']='checkbox';
    			  $content=View::factory("form/checkbox")->set($details);
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
    			case 'select_enum':
    			     foreach (Arr::get($details,'options',array()) as $option){
    			       $opt[$option]=$option;
    			     }
    			     $details['options']=$opt;
    		  
    		  $details['type']="select {$details['type']}";
    			case 'select':
      		  $content=View::factory("form/select")->set($details);
    		  break;
    		  
    		  //Files - to inc js-plupload
    		  case 'multiple_file':
    		  case 'file':
    		      $this->default['multipart']=true;
    		      $content=View::factory("form/file")->set($details);
    		  break;
    		  
    		  //for images selction - import / export etc
    		  case 'image_radio':
    		  case 'image_chackbox':  
    		  case 'image_select':
    		    $content=View::factory("form/image-picker")->set($details);
    		  break;		  
    		  }
  	   
  	   
  	   return View::factory("form/wrapper")->set($details)->set('content',$content);
  	   
  	  
  	  
  	  ////return $items;
  	}
  	
  	

}




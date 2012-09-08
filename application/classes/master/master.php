<?php
 defined('SYSPATH') or die('No direct script access.');

 class Master_Master extends Controller_Template
  {
     public  $internal=false;
     public  $is_ajax=false;
     
     
     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
     public function before()
      {
      
      	 
         // Run anything that need ot run before this.
         parent::before();
         
         $_REQUEST['current']=Arr::get($_REQUEST,'current',array());
         
        // if ($this->request->initial()->is_ajax() || Arr::get($_GET,'ajax',false)) {
        //    $this->is_ajax=true;
         //   $this->auto_render = FALSE;
         //   $this->json=array('status'=>'ok');
         //} 
         
         //Need a new way to do this
         //if (!$this->request->is_initial()){
         if (!$this->request->is_initial() || $this->request->param('format')){
            $this->internal=true;
            $this->auto_render = FALSE;
            $this->template->content          = '';
         }
         
         if($this->auto_render)
          {
            // Initialize empty values
            $this->template->title            = '';
            $this->template->titlepart        = array();
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copywrite   = '';
            $this->template->page             = '';
            $this->template->flash            = '';
            $this->template->styles           = array();
            $this->template->scripts          = array();
          }
      }
 		
     /**
      * Fill in default values for our properties before rendering the output.
      */
     public function after()
      {
          if($this->auto_render)
          {
             // Define defaults
             $styles                  = array(            
                                            'assets/css/reset.css' => 'screen',                   
                                            'assets/css/text.css' => 'screen',                                                                      
                                          );
             $scripts                 = array(
                                           'assets/javascript/mootools-core-1.3.2-full-compat-yc.js',
                                           'assets/javascript/mootools-more-1.3.2.1.js',
                                          );
             

             // Add defaults to template variables.
             $this->template->styles  = array_merge($styles,$this->template->styles);
             $this->template->scripts = array_merge($scripts,$this->template->scripts);
           }
         // Run anything that needs to run after this.
         
          if ($this->internal && $this->auto_render == FALSE){
            $this->response->body( $this->template->content );
          }
          
          if ($this->is_ajax ) {
            $this->json=Arr::get($_POST,'json',$this->json);
            //$this->json['raw']=htmlentities(  $this->template->content);
            $this->response->body( json_encode($this->json) );
            //echo json_encode(Arr::get($_REQUEST,'json',$this->json));
          }
          
         parent::after();
      
         // echo $this->auto_render?"Yes":'no';

      }  
     
   public function fof(){
      throw new HTTP_Exception_404('File not found!');
   }       
  public function update_subscription_details($force=false){
     if ($force || !$this->account->id || Date::span(strtotime($this->account->checked_at),time(),'days') ){
       $site='evography';
       $token='edb947a47ddb4d2547569d64fc990a12c56e86fe';
       Spreedly::configure($site, $token);
       try{
         $sub=SpreedlySubscriber::find($this->user->id);
       } catch(SpreedlyException $e){
         return;
       }
       if (!is_object($sub)) {
       $sub=SpreedlySubscriber::create($this->user->id, $this->user->email, $this->user->name);
       $sub->activate_free_trial(12791);
       $sub=SpreedlySubscriber::find($this->user->id);
       }
       
       
       $this->account->set('user_id',$this->user->id);
       $this->account->set('active',$sub->active);
       $this->account->set('type',$sub->subscription_plan_name);
       $this->account->set('recurring',$sub->recurring);
       $this->account->set('renew_date',date('Y-m-d H:i:s',$sub->active_until));
       $this->account->set('card_expired',$sub->card_expires_before_next_auto_renew);
       $this->account->set('checked_at', date('Y-m-d H:i:s',time()));
       $this->account->save();
     }
  } 
  function action_validate(){
     $result=array();
     $query=Arr::merge($this->request->query(),$this->request-> post());
     foreach ($query as $model=>$fields){
     if (!is_array($fields)) continue;
     $validate= Validation::factory( $fields );
      try {
         $$model= Orm::factory($model);
      } catch (error $e) {
        continue;
      }
      foreach ($fields as $field=>$value) {
       if (!$rule=Arr::get( $$model->rules(true), $field )) continue;
        $validate->rules($field,$rule);
      }
      $validate->check();
      $result[$model]=$validate->errors('models/'.$model);
     }    
     
     switch($this->request->param('format')){
        case 'json':
          $this->template->content=json_encode($result);
        break;
        
        default:
         $this->fof();
        break;
     }   
      // query /validate.json?username=johnsmith
  }

}

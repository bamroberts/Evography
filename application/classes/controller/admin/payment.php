<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Payment extends Master_Admin {

const INVOICE_DATE = "d M Y";
const INVOICE_DATE_TIME = "d M Y h:i:s";
  
  var $site='evography';
  var $token='edb947a47ddb4d2547569d64fc990a12c56e86fe';
  
  public function before(){
    parent::before();
    $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'payment','action'=>'','id'=>'')),'Payment');
   // if ($this->request->action()!='index') {
   //    $a=$this->request->action();
   //    $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'payment','action'=>$a,'id'=>'')),ucwords($a));
   // }
  }
  
  public function action_index(){
  //list payment options an current option
    $this->template->content = View::factory('admin/payment')
        ->bind('sub', $sub);
    
    //Sorry our payment provider appear to be experiencing some problems.      
        
    Spreedly::configure($this->site, $this->token);
    $sub=SpreedlySubscriber::find($this->user_id);
    

    //$user=Auth::instance()->get_user();
    //SpreedlySubscriber::create($user->id, $user->email, $user->name);
   //$sub->activate_free_trial(12791);
  }
  
  public function action_details(){
   //update
  }
  
  public function action_history(){
  //list of payment history
    $this->template->content = View::factory('admin/payment-history')
        ->bind('sub', $sub);
    Spreedly::configure($this->site, $this->token);
    $sub=SpreedlySubscriber::find($this->user_id);
  }
  
  public function action_invoice(){
  $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'payment','action'=>'history','id'=>'')),'History');
  //details of a particular invoice
    $this->template->content = View::factory('admin/payment-invoice')
        ->bind('invoice', $invoice);
    Spreedly::configure($this->site, $this->token);
    $sub=SpreedlySubscriber::find($this->user_id);
    $id=$this->request->param('id');
    if(!$invoice=Arr::get($sub->invoices,$id,false)){
      $this->fof();
    }
  }
  
  
  public function action_plans(){
  //list payment options and current option
    $this->template->content = View::factory('admin/payment-plans')
        ->bind('sub', $sub)
        ->bind('plans', $plans);
    Spreedly::configure($this->site, $this->token);
    $sub=SpreedlySubscriber::find($this->user_id);
    $plans=SpreedlySubscriptionPlan::get_all();        
  }  
  
  public function action_checkout(){
  $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'payment','action'=>'plans','id'=>'')),'Plans');
    $plan_id=$this->request->param('id');
    if(!$plan_id){
      $this->fof();
    }
    $this->template->content = View::factory('admin/payment-checkout')
        ->bind('plan', $plan)
        ->bind('invoice', $invoice)
        ->bind('columns', $columns)
        ->bind('data', $payment)
        ->bind('errors', $errors);
    $payment=ORM::factory('payment');
    $columns=$payment->_model;
        
    $user=Auth::instance()->get_user();
    Spreedly::configure($this->site, $this->token);
    //SpreedlySubscriber::create($user->id, $user->email, $user->name);
    $plan=SpreedlySubscriptionPlan::find($plan_id);
    $invoice=SpreedlyInvoice::create($user->id, $plan_id, $user->name, $user->email);
    //$inv=SpreedlySubscriptionPlan::get_all();
    //echo debug::vars($inv);
    
    if ($post=$this->request->post()){
       try {
         $payment->values($post,array('card_number','card_type','verification_value','month','year','card_name'));
         $payment->check();
       }
       catch(ORM_Validation_Exception $e) {
  	      $errors=$e->errors('models');
          Hint::set(Hint::ERROR,"There are problems with your credit card details");
          return;
  	   }    
    
       try {
          $name=explode(' ', $payment->card_name,2);
          $result = $invoice->pay($payment->card_number, $payment->card_type, $payment->verification_value,$payment->month,$payment->year,$name[0],$name[1]);
          if ($result instanceof SpreedlyErrorList) {
            foreach ($result->get_errors() as $error) {
              Hint::set(Hint::ERROR,$error);
            }
          } else {         
            Hint::set(Hint::SUCCESS,"Your payment went through. Your subscription is now live!");
            $this->update_subscription_details(true);
            //email
            //redirect
          }
       } catch (SpreedlyException $e) {
         Hint::set(Hint::ERROR,"An unknown error occured: {$e->getMessage()}! Please try again or contact support.");
       }    
    }
  }
  
  
  
  public function action_cancel(){
   Spreedly::configure($this->site, $this->token);
   $sub = SpreedlySubscriber::find($this->user_id);
   $sub->stop_auto_renew();
   $this->update_subscription_details(true);
   //send 'sorry to see you go' email
  }
}
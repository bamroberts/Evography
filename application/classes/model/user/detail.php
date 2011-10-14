<?php defined('SYSPATH') or die('No direct script access.');
class Model_User_Detail extends ORM
{
  protected $_belongs_to = array('user' => array());
  protected $_primary_key='id';
  
  protected $_model=array(
    'nick'=>array(),
    'address'=>array('formtype'=>'textarea'),
    'company'=>array(),
  );
  
 //Nickname
 //Actual Name
 //Company (optional)
 //Address
 //Subscription type: Trial / Single / Sub / Credit
   //Trial expires on xxx.
   //Account due for renewal on xxx.
   //Next payment for £xxx due on xxx.
   //You have xx credits left.
 //Payment plan
   //Buy more credits
   //Upgrade to monthly subscription
   //Upgrade to anual subscription
 //Domain - internal / external
}


//All these options can be over ridden on an album by album bassis.
//These form the default though
 
 //Watermark?
 //Export message sign off
 //Theme
 //Cart - ?
 //Cart setup
 //Default entry point ie domain.xxx.com/ ->
 //Live
 //Private - requires password to view.
 //Enable facebook
 
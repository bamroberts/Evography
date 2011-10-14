<?php defined('SYSPATH') or die('No direct script access.');

class Model_Payment extends ORM {
  protected $_table_name = 'users';
   //$card_number, $card_type, $verification_value, $month, $year, $first_name, $last_name
  public $_model = array( 
  'card_name'=>array(  
    'name'=>'Name on card',
  ), 
  'card_type'=>array(  
    'name'=>'Your card type',
    'formtype'=>'select',
    'options'=>array('visa'=>'VISA', 'master'=>'Master Card', 'american_express'=>'American Express'),
  ),
  'card_number'=>array(  
    'name'=>'Your card number',
  ),   
  'verification_value'=>array(  
    'name'=>'CSV digits',
  ),
  'month'=>array(  
    'name'=>'Expirary month',
    'formtype'=>'select_data',
    'model'=>'payment',
    'function'=>'months',
  ), 
  'year'=>array(  
    'name'=>'Expirary year',
    'formtype'=>'select_data',
    'model'=>'payment',
    'function'=>'years',
  )
 );  
  
 public function rules()
	{
		return array(
			'card_name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 255)),  
			),
		  'card_type' => array(
				array('not_empty'), 
			),
			'card_number' => array(
				array('not_empty'),
				array('credit_card'),  
			),
			'verification_value' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 4)),  
			),
			'month' => array(
				array('not_empty'),
				array('digit'),
			),
			'year' => array(
				array('not_empty'),
				array('digit'),
			),
		);
	}
  
 public function months(){
   return Date::months(Date::MONTHS_LONG);
 } 
 
 public function years(){
   $year=(int) date('Y',time());
   return Date::years($year, $year+10);
 }
  
}
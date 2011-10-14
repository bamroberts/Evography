<?php defined('SYSPATH') or die('No direct script access.');
class Model_comment extends ORM
{
  protected $_belongs_to = array('album' => array(),'image' => array(),'user'=>array());
  protected $_model =array (
      'message'=>array(
          'formtype'=>'textarea',
      )
  );
    
  public function rules()
	{
		return array(
			'message' => array(
				array('not_empty'),
			),
		);
  }

}
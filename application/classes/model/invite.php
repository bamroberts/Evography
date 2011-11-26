<?php defined('SYSPATH') or die('No direct script access.');
class Model_Invite extends ORM
{
protected $_table_name = 'invite';

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 127)),
				array('email'),
				array(array($this, 'email_available'), array(':validation', ':field')),
			),
		);
	}
	
	public function email_available(Validation $validation, $field)
  {
    if ($this->unique_key_exists($validation[$field], 'email'))
    {
        $validation->error($field, 'email_available', array($validation[$field]));
    }
  }
	
}
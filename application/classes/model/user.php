<?php defined('SYSPATH') or die('No direct script access.');
class Model_User extends Model_Auth_User
{
    
  protected $_model=array(
    'username'=>array(),
    'password'=>array('formtype'=>'password',),
    'email'=>array(),
    'remember_me'=>array('formtype'=>'checkbox','name'=>'Keep me logged in'),
  );
    //protected $_has_many = array('images' => array('model' => 'image', 'through' => 'favorite', 'foreign_key' => 'user_id',));
    //protected $_model = array();
    
   
	/**
	 * A user has many tokens and roles
	 *
	 * @var array Relationhips
	 */
	protected $_has_many = array(
		'user_tokens' => array('model' => 'user_token'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
	);
  protected $_has_one = array(
		'details'     => array('model' =>'user_detail', 'foreign_key'=>'id'),
		'options'     => array('model' =>'user_option' , 'foreign_key'=>'id'),
		'facebook'    => array('model' =>'user_facebook'),
		'account'     => array('model' =>'user_account'),
			);

  
  
	/**
	 * Rules for the user model. Because the password is _always_ a hash
	 * when it's set,you need to run an additional not_empty rule in your controller
	 * to make sure you didn't hash an empty string. The password rules
	 * should be enforced outside the model or with a model helper method.
	 *
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
				array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
				array(array($this, 'username_available'), array(':validation', ':field')),
			),
			'password' => array(
				array('not_empty'),
				array('min_length', array(':value', 6)),

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
	
	public function filters()
    {
    return array(
        'username' => array(
            array('trim'),
            array('strtolower'),
        ),
        'password' => array(  
            array('trim'),
            //we have taken this away as we cannot validate it once hashed.
            //array(array($this, 'hash_password')),
        )
    );
  }
  
	public function create_user($values, $expected)
	{
	  $this->values($values, $expected)->create();
	  $this->set('password',Auth::instance()->hash($this->password))->save();	
	}

	//public function filters() {return array();}
	  /**
	 * Merges the $_model values with the model original column data
	 * Used for auto form creation
	 *
	 * 
	 * @return  array
	 */
    public function list_columns(){
    	$colums=parent::list_columns();
      return Arr::merge($colums,$this->_model);
    }

}
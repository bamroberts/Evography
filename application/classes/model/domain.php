<?php defined('SYSPATH') or die('No direct script access.');
class Model_Domain extends ORM
{
  protected $_belongs_to = array(
    'user' => array(),
    'node'    => array('model' =>'album', 'foreign_key'=>'node_id'),
		'theme'   => array('model' =>'theme' , 'foreign_key'=>'theme_id'),
    );
  protected $_has_many = array(
		
  );
  
  protected $_model =array (
      'name'=>array(
      
      ),
      'node_id'=>array(
         'formtype'=>'db_tree_select',
         'model'=>'album',
         'function'=>'find_mine',
      ),
      'theme_id'=>array(
         'formtype'=>'db_select',
         'model'=>'theme',
         'function'=>'find_mine',
      ),
      'published'=>array(
         'formtype'=>'checkbox',
      ),      
  );
 
 public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 255)),  
				array(array($this, 'domain_available'), array(':validation', ':field')),
				array(array($this, 'domain_valid'), array(':validation', ':field')),
			),
			'node_id' => array(
				array('not_empty'),
			),
		);
	}
   
 	/**
	 * Does the reverse of unique_key_exists() by triggering error if username exists.
	 * Validation callback.
	 *
	 * @param   Validation  Validation object
	 * @param   string      Field name
	 * @return  void
	 */
	public function domain_available(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'name'))
		{
			$validation->error($field, 'domain_available', array($validation[$field]));
		}
	}
	
	   
 	/**
	 * Is this a valid domain name	 *
	 * @param   Validation  Validation object
	 * @param   string      Field name
	 * @return  void
	 */
	public function domain_valid(Validation $validation, $field)
	{
	  
	  if (!stripos($validation[$field], '://' ))  {echo $validation[$field]="http://".$validation[$field];}
	  
	  $url=parse_url($validation[$field]);
	  
	  $scheme=Arr::get($url,'scheme','http');
	  $domain=Arr::get($url,'host');
	  $this->$field="{$scheme}://$domain/";
	  
    if (!preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $this->$field)) {		
			$validation->error($field, 'domain_valid', array($validation[$field]));
		}
	 }
	
}
<?php 
defined('SYSPATH') or die('No direct script access.');

class Orm extends Kohana_Orm {
  protected $_model=array();
  /**
	 * Merges the $_model values with the model original column data
	 * Used for auto form creation
	 *
	 * 
	 * @return  array
	 */
    public function list_columns(){
    	$columns=parent::list_columns();
    	//if (is_array($fields))	return Arr::extract(Arr::merge($columns,$this->_model),$fields);
    	return Arr::merge($columns,$this->_model);
    }
    	 
	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 */
	public function unique_key_exists($value, $field = NULL)
	{
		if ($field === NULL)
		{
			// Automatically determine field by looking at the value
			$field = $this->unique_key($value);
		}

		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute($this->_db)
			->get('total_count');
	}
	
	
  public function delete_all(){
      foreach ($this->_has_many as $key=>$connection) {
        $items = $this->$key->find_all();
        foreach ($items as $item) {
          if ($connection['through']){
            //do we need to check orphan status and remove?
            $this->remove($key, $item);
          } else {
            $item->delete_all();
          }
        }
      }
      foreach ($this->_has_one as $connection) {
        $items = $this->$connection->find_all();
        foreach ($items as $item) {
            $item->delete_all();
        }
      }
      $this->delete();  
    }
    
    
  //function that lets us load DB default if record fails to load  
  public function __construct($id=null){    
    parent::__construct($id);
      if (!$this->_loaded){
        $this->set_default();
      }
  }
  
  private function set_default(){
    $columns=$this->list_columns();
    foreach ($columns as $key=>$column){
      if($value=Arr::get($column,'column_default',false)) {
        $this->set($key,$value);
      }
    }
    return;
  }

}
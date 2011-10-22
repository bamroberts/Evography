<?php defined('SYSPATH') or die('No direct script access.');
class Model_Image extends ORM
{
    
    public $_order = 'order';
    public $_order_direction = 'ASC';
    
    protected $_sorting   = array('order'=>'ASC');
    
	  protected $_has_many = array(
								'albums' => array('model' => 'album', 'through' => 'album_image'),
								'favorite' => array(),
								'users' => array('model' => 'user', 'through' => 'user_images'),
								'comment' => array()
								);
								
	  protected $_belongs_to = array(
        'added_by' => array(
            'model'       => 'user',
            'foreign_key' => 'add_user_id',
        ),
        'album' => array('model' => 'album','foreign_key'=>'album_id'),
    );
    
    protected $_model=array(
      'path'=>array('column_default'=>'/dummy.jpg')
      );
    
							
							
	public function next() {
		$image_set=$this->albums->find()->images->order_by($this->order(),$this->order_direction())->find_all();
		$next=null;
		$end=false;
		foreach($image_set as $image) {
			if ($end) {return $image;}
			if ($image->id==$this->id) {$end = true;}
		}
	}
	
	public function previous() {
		$image_set=$this->albums->find()->images->order_by($this->order(),$this->order_direction())->find_all();
		$previous=null;
		foreach($image_set as $image) {
			if ($image->id==$this->id) {return $previous;}
			$previous=$image;
		}
    }
	public function first() {
	  return $this->albums->find()->images->order_by($this->order(),$this->order_direction())->find();
	}
	
	public function last() {
	  return $this->albums->find()->images->order_by($this->order(),$this->order_rev(true))->find();
	}
	
	public function order() {
	  if (!$this->order) $this->_order=$this->_primary_key;
	  return "$this->_order";
	}
	
	public function order_direction() {
	    if (!$this->_order_direction) $this->_order_direction='ASC';
		return $this->_order_direction;  
	} 
	
	public function order_rev($update=false) {
	$this->_order_direction=($this->_order_direction=='ASC')?'DESC':'ACS';
		$direction = $this->order_direction();
		if (!$update) $this->order_rev(true);
		return $direction;  
	}
	
	function watermark(){
   // $sql="SELECT w.* 
   //       FROM album_tree a
    //      RIGHT JOIN watermark w on w.id = a.id
     //     WHERE lft <= (SELECT lft FROM album_tree WHERE id={$this->album_id})
      //    AND rgt >=(SELECT rgt FROM album_tree WHERE id={$this->album_id})
       //   ORDER BY level DESC
        //  LIMIT 1
       // ";
    //$query=DB::query(Database::SELECT,$sql)->as_object()->execute();
    //return $query->current();
    
//These two queries essentially do the same thing, this one returns an instance of the model though and as such is more future proof    
$query = self::factory('watermark')
      ->join('album_tree','left')->on('watermark.id','=','album_tree.id')
			->where('album_tree.lft', '<=', $this->album->left())
			->where('album_tree.rgt', '>=', $this->album->right())
			->order_by('level', 'DESC')
			->find();			
return $query;    
  }

public function __get($column)
	{
		switch ($column)
		{
			case 'watermark':
				return $this->watermark();
			default:
				return parent::__get($column);
		}
	}

	
	
}
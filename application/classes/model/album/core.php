<?php defined('SYSPATH') or die('No direct script access.');

class Model_Album_Core extends ORM_Tree {

  protected $_table_name = 'album_tree';
  
  protected $_has_many = array(
       'images' => array(
          'model' => 'image', 
          //'through' => 'album_image',
          'foreign_key'=>'album_id',
       ),
      'comment' => array(
          'model' => 'comment',
          'foreign_key'=>'album_id',
       ),
      'albums' => array(
          'model' => 'album',
          'foreign_key'=>'parent_id',
       ),
       
    );
    
  protected $_has_one = array(
      		'watermark'    => array('model' =>'watermark', 'foreign_key'=>'id'),
      		'password'     => array('model' =>'album_password',  'foreign_key'=>'id'),        
    );  
	
  protected $_belongs_to = array(
    'style' => array(
        'model'       => 'styles',
        'foreign_key' => 'style_id',
    ),
    'owner' => array(
        'model'       => 'user',
        'foreign_key' => 'user_id',
    ),
    'cover' => array(
        'model'       => 'image',
        'foreign_key' => 'cover_image_id',
    ),  
    'added_by' => array(
        'model'       => 'user',
        'foreign_key' => 'add_user_id',
    ),

  );

protected $_model = array(
    'id'=>array(  
    'name'=>'Id',
    'hidden'=>true,
  ),  
  'name'=>array(  
    'name'=>'Album name',
  ),  
  'slug'=>array(  
    'name'=>'URL slug',
    'help'=>'A nice informative link rather than ?album=18 in the. It must be lowercase and only contain  a mix of letters, numbers and these sysmbols: - _ +.  If you leave it blank we will make one for you.',
  ),  
  'desc'=>array(  
    'name'=>'Album description',
    'formtype'=>'textarea',
  ),
  'type'=> array(
    'formtype'=>'enum',
  ),
  'theme'=>array(  
    'name'=>'Style',
    'formtype'=>'radio',
    'options'=>array('default'),
  ),
  'private'=>array(  
    'name'=>'Album requires password',
    'formtype'=>'checkbox',
  ), 
  'comments'=>array(  
    'name'=>'Users can comment on this album',
    'formtype'=>'radio',
    'options'=>array('No Comments','Comments require approval','Open comments'),
  ), 
  'published'=>array(  
    'name'=>'The album is live',
    'formtype'=>'checkbox',
  ), 
  'cart'=>array(  
    'name'=>'Cart: Items can be purchsed from this album',
    'formtype'=>'checkbox',
  ),
   
  'facebook'=>array(  
    'name'=>'Facebook: User can interact with facebook (likes, comments, imports, exports)',
    'formtype'=>'checkbox',
  ),
  'export'=>array(  
    'name'=>'Export: Users can download or export this album',
    'formtype'=>'checkbox',
  ), 
  'open'=>array(  
    'name'=>'Open album: user can contibute their own images',
    'formtype'=>'checkbox',
  ),   
  
  'add_date'=>array(  
    'name'=>'Added on',
    'formtype'=>'datetime',
    'format'=>array(
    	'helper'=>'Date',
    	'method'=>'formatted_time',
    	'setting'=>'D jS F Y',
    ),
  ),  
  'add_user_id'=>array( 
    'name'=>'Added by',
    'formtype'=>'readonly',
    'type'=>'link',
    'link'=>'added_by->username',
    
  ),  
  'mod_date'=>array(  
    'name'=>'Updated on',
    'formtype'=>'text',
    'format'=>array(
    	'helper'=>'Date',
    	'method'=>'formatted_time',
    	'setting'=>'D jS F Y',
    ),
  ),  
  'mod_user_id'=>array( 
    'name'=>'Updated by',
    'formtype'=>'text',
    'type'=>'link',
    'link'=>'edited_by->username',
  ),   
 );  
 
 protected $_store=array();
 
 public function save(Validation $validation = NULL)
	{
      if (!$this->slug) $this->slug=$this->name;
      $this->slug=URL::slug($this->slug);
      return parent::save($validation);
	}
 

  public function cover(){
        if (!$this->cover_image_id){
          $this->cover_image_id=$this->images->find()->id;
         // if (!$this->cover_image_id){
         // $this->cover_image_id->$this->first_child->cover()->id;
         // }
          $this->save();
        }
    		return $this->cover;
    }
    
  public function find_mine(){
    $master=$this->where('id','=',Auth::instance()->get_user()->start_node)->find();
    return $master->get_descendants(true);
  } 
  
  public function get_path(){
    $session=Session::instance();
    if ($root_node=$session->get('root_node',false)) 
    { 
      $root_node="
          AND at2.lft > (SELECT lft FROM album_tree WHERE id ='{$root_node}')
          AND at2.rgt < (SELECT rgt FROM album_tree WHERE id ='{$root_node}')
        ";
    }
    $sql="SELECT a.id,
          (
            SELECT group_concat(at2.slug ORDER BY at2.level ASC SEPARATOR '/') 
            FROM album_tree at2 
            WHERE at2.lft <= a.lft 
            AND at2.rgt >= a.rgt
            $root_node
          ) path
          FROM album_tree a
          WHERE id='{$this->id}'
          ";
    $query=DB::query(Database::SELECT,$sql)->as_object()->execute();
    $result=$query->current();
    return $result->path;
  }
  
  function get_nested($table){
  //Neat little function that inherits the first available joined record in a hirachy i.e. for inheriting a parents attributes
    $query = self::factory("{$table}")
      ->join("{$this->_table_name}",'left')->on("{$table}.id",'=',"{$this->_table_name}.id")
			->where("{$this->_table_name}.lft", '<=', $this->left())
			->where("{$this->_table_name}.rgt", '>=', $this->right())
			->order_by('level', 'DESC')
			->find();			
    return $query;    
  }
  
  function get_nested_price($table){
  //Neat little function that inherits the first available joined record in a hirachy i.e. for inheriting a parents attributes
    $query = self::factory("{$table}")
      ->join("{$this->_table_name}",'inner')->on("{$table}.album_id",'=',"{$this->_table_name}.id")
			->where("{$this->_table_name}.lft", '<=', $this->left())
			->where("{$this->_table_name}.rgt", '>=', $this->right())
			->order_by('category', 'ASC')
			->order_by('level', 'DESC')
			->find_all();			
    return $query;    
  }



 
 public function __get($column)
	{
		switch ($column)
		{
			case 'path':
				return $this->get_path();
		 // case 'style':
		 // case 'theme':
		  case 'prices':
		    if (isset($_store[$column])) return $_store[$column];
				return $_store[$column]=$this->get_nested_price("album_{$column}");
		  case 'password':
		    $column='album_'.$column;
		  case 'watermark':      
		  case 'connectivity':
		  case 'pricing':
		     if (isset($_store[$column])) return $_store[$column];
				return $_store[$column]=$this->get_nested($column);
			default:
				return parent::__get($column);
		}
	}

}

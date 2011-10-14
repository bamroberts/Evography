<?php defined('SYSPATH') or die('No direct script access.');
class Model_Watermark extends ORM
{
  protected $_table_name='watermark';
  protected $_belongs_to = array('album' => array());
  protected $_primary_key='id';
  
  public $_model = array( 
  'path'=>array(  
    'name'=>'Upload an Image',
    'formtype'=>'file',
  ), 
  'position'=>array(  
    'name'=>'Position the watermark',
    'formtype'=>'select enum',
  ),
  'opacity'=>array(  
    'name'=>'Opacity (0-100)',
  ),   
  'active'=>array(  
    
  ),
 );

   
}

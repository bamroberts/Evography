<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date helper.
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) 2007-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Config_file extends Kohana_config_file {
  public function merge(array $import){
    foreach($import as $key=>$value){

        if (is_numeric($key) && is_string($value))
        {
          $key=$value;
          $value=array();
        }
        
        if (is_array($value)){
          $value=Arr::merge($this->get($key,array()),$value);
        }
        
        if ($value===false) return $this->offsetUnset($key);
        
        $this->set($key,$value);
    }
  }
  
  public function flat($array=false,$prefix=null)
  { 
      if ($array===false) $array= $this;
      
      $flat = array();
      foreach ($array as $key => $value)
      {
          if (is_array($value))
          {
              $flat[$key] = true;
              $flat += $this->flat($value,$key.'-');
          }
          else
          {
              $flat[$prefix.$key] = $value;
          }
      }
      return $flat;
  }
}
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
class Date extends Kohana_Date {
  const MONTHS_LONG  = '%m - %B';
  
  static function long($date){
     return Date::formatted_time($date,'D jS F');
  }
}
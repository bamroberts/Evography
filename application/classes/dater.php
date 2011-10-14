<?php defined('SYSPATH') or die('No direct script access.');
 class Dater extends Kohana_Date {
    
    static function in($date=false){
      $date=($date)?strtotime($date):time();
      $time=($d=date(' H:i:s',$date)==' 00:00:00')?date(' H:i:s'):$d;
      
      return date('Y-M-d',strtotime($date)).$time;
    }
    
    static function form_date($date=false){
      $date=($date)?strtotime($date):time();
      return date('d M Y',$date);
    }
    
    
    static function form_date_time($date=false){
      $date=($date)?strtotime($date):time();
      return date('d M Y H:i:s',$date);
    }
    
    static function display($date=false){
      $date=($date)?strtotime($date):time();
      return date('D jS F Y',$date);
    }  
    
    static function days_left($date) {
     $time=Date::span(strtotime($date),NULL, 'months,days');
     $left=($time['months']>0)
        ?"about {$time['months']} months time"
        :"{$time['days']} days time";
    
    return $left;
    }   
  }
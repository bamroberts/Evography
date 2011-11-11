<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Account extends Master_Admin {

  function action_index(){}
  function action_payment(){
    $this->sub();
  }
  function action_domains(){
    $this->sub();
  }
  function action_user(){
    $this->sub();
  }
}
<form method="post" action="<?php echo Request::current()->url(array('controller'=>'comment','action'=>'add'));?>" class="form-stacked">
   <fieldset>
   <?php 
   echo View::factory('themes/basic/blocks/forms/input')
    ->set('name','name')
    ->set('label','Name')
    ->bind('value',$value)
    ->bind('error',$error)
    ->set('help','As to be displayed with your message')
    ->set('placeholder','Please enter your name');
?>
<?php 
   echo View::factory('themes/basic/blocks/forms/text')
    ->set('name','message')
    ->set('label','Message')
    ->bind('value',$value)
    ->bind('error',$error)
    ->set('help','')
    ->set('placeholder','Please enter your message');
?>
    <div class="actions"> 
      <button type="submit" name="action" class="btn">Add comment</button>
    </div>
   </fieldset>
  </form>

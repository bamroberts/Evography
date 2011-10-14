<form>
 <fieldset>
  
<?php 
$columns=array(
  'hidden'=>array(
    'formtype'=>'hidden',
  ),
  'plain'=>array(
    'formtype'=>'plain',
    'default' =>'default value',
  ),
  'text'=>array(
    'formtype'=>'',
  ),
  'password'=>array(
    'formtype'=>'password',
  ),
  'textarea'=>array(
    'formtype'=>'textarea',
  ),
  'checkbox'=>array(
    'formtype'=>'checkbox',
    'helper'=>'Check this check box?',
  ),
  'checkbox_group'=>array(
    'formtype'=>'checkbox_group',
    'options'=>array('Option #1','Option #2','Option #3'),
  ),
  'radio'=>array(
    'formtype'=>'radio',
    'options'=>array('Option #1','Option #2','Option #3'),
  ),
  'date'=>array(
    'formtype'=>'date',
  ),
  'date_time'=>array(
    'formtype'=>'date_time',
  ),
  'select'=>array(
    'formtype'=>'select',
    'options' =>array('Option #1','Option #2','Option #3'),
  ),
  'file'=>array(
    'formtype'=>'file',
  ),
  'error'=>array(
    'formtype'=>'text',
  ),
  'text'=>array(
    'formtype'=>'text',
  ),
  'text'=>array(
    'formtype'=>'text',
  ),

);
echo Form::render($columns,array(),array('error'=>'Problems with this entry'));
?>
<a class="button" href="#">Cancel</a>
<button class="default" type="submit" name="action" value="save">Save</button>
<button type="submit" name="action" value="duplicate">Save as duplicate</button>
<button class="warn" type="submit" name="action" value="delete">Delete</button>


 </fieldset>
</form>

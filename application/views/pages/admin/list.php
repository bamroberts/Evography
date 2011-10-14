<table>
 <tr>
  <?php foreach ($columns as $name=>$details) : ?>
    <?php if (!isset($details['hidden']) || !$details['hidden']) : ?>
      <th><?php  echo (isset($details['name']))?$details['name']:$name; ?></th>
    <?php endif; ?>
  <?php endforeach; ?>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
 </tr>
 <?php foreach ($results as $row):?>
 <tr>
  <?php foreach ($columns as $field=>$details) :?>
    <?php if (!isset($details['hidden']) || !$details['hidden']) : ?>
      <?php if (isset($details['format'])) $row->$field=call_user_func($details['format']['helper'].'::'.$details['format']['method'],$row->$field,$details['format']['setting']);?>
      <?php if (Arr::get($details,'type')=='link' && Arr::get($details,'link') ) {
      		$link=Arr::get($details,'link');
      		 eval('$d =  $row->'.$link.';');
      		 ?>
      		 <td class=""><?php echo $d; ?></td>
      		<?php }else { ?>
      		
      <td class=""><?php echo $row->$field; ?></td>
      
    <?php } endif; ?>
  <?php endforeach; ?>
  <?php foreach ($links as $key=>$link) : ?>
    <td class="<?php echo $link->class; ?>"><a class="minibutton" href="<?php echo Request::current()->url(array('action'=>$link->class,'id'=>$row->id)); ?>"><span><?php echo $link->text; ?></span></a></td>
  <?php endforeach; ?>
 </tr>
 <?php endforeach; ?>
</table>
 <?php echo $pagination->render(); ?>
 <?php echo $pagination->details(); ?>
 
 <pre>
 <?php print_r($columns);?>
 </pre>
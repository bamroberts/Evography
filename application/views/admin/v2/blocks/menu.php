<?php $sections=array('Dashboard'=>'','Galleries'=>'collection','Images'=>'image','Admin'=>'options','Sales'=>'style','Account'=>'account'); ?>
<ul>
  <?php foreach ($sections as $name=>$controller) : ?>
    <li class="<?php echo ($current==$controller)?'current':false ; ?>">
      <a href="<?php echo Route::URL('admin',array('controller'=>$controller)); ?>"><?php echo $name; ?></a>
    </li>
  <?php endforeach; ?>
</ul>
      
      
      
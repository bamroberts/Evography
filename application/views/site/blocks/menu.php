<?php $sections=array('Home'=>'','Tour'=>'tour','Prices'=>'pricing','Signup'=>'signup'); ?>
<ul>
  <?php foreach ($sections as $name=>$action) : ?>
    <li <?php echo (Request::initial()->action()==$action)?'class="active"':false ; ?>>
      <a href="<?php echo Route::URL('site',array('action'=>$action)); ?>"><?php echo $name; ?></a>
    </li>
  <?php endforeach; ?>
</ul>
      
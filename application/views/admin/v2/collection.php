<?php $sections=array('Summary'=>'index','Details'=>'edit','Cover'=>'cover','Style'=>'style','Access'=>'password','Watermarks'=>'watermark','Cart'=>'shopping',); 
if (Request::initial()->action()=='add'){
  $sections=array('Create new'=>'add');
}
?>

<section class="row album">
  <nav>
    <ul class="tabs">
    <?php foreach ($sections as $name=>$action) : ?>
      <li class="<?php echo (Request::initial()->action()==$action)?'current':false ; ?>">
        <a href="<?php echo Request::initial()->url(array('action'=>$action)); ?>"><?php echo $name; ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
  </nav>
  <div class="tabs">
  	<div class="tab current">
	  	<?php echo $content; ?>
  	</div>
  </div>
</section>
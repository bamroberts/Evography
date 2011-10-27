<h2><?php echo $image->name; ?></h2>
<div class="well">  
<div class="row">
  <div class="span9">
     <img src="/images/dynamic/<?php echo $image->filehash;?>/500x1000xfit.jpg" alt="Image <?php echo $image->name; ?>" class="media" />
  </div>
  
  
 
 <div class="span6">
 
 <?php if (true || $facebook) : ?>
     <?php //echo $facebook->like); ?>
    <?php echo facebook::like(array('action'=>false)); ?>
 <?php endif; ?>
 
 <?php if (true || $image->album->cart) : ?>
	<a class="" href="<?php echo Request::current()->url(array('controller'=>'buy','action'=>'image','id'=>$image->id));?>/">
		<span class="btn primary">Buy this image</span> for £3.99.
	</a>
 <?php endif; ?>

<div class=""> 
 This image has been viewed <?php echo $image->views;?> 
 times since <?php echo Date::formatted_time($image->taken,'D jS F Y');?> 
 <a href="<?php echo Request::current()->url(array('controller'=>'favorie','action'=>'add','id'=>$image->id));?>" class"btn">
 	Add to favourite
 </a> 
 (<?php echo $image->favorite->count_all(); ?> times)
</div>

<div class=""> 
 <h4>Comments</h4>
 <?php echo $comments; ?>
</div> 

</div>
</div>

</div> 

<div class="well">  
<div class="row">
  <div class="span4">
  <?php if ($previous) : $image=$previous; ?>
  	<a href="/<?php echo Request::current()->uri(array('id'=>$image->id,'action'=>false));?>">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.jpg" alt="image <?php echo $image->name; ?> preview" class="media" />
      <p>Previous image</p>
  	</a>
  <?php endif; ?> 
  </div>
  
  <p class="span7 text-center">
  Back to the album <br />
  <a class='btn' href="<?php echo Route::url($album->id);?>">
    <span>
      <?php echo $album->name ?>
    </span>
  </a>
  </p>
  
  <div class="span4 text-right">
  <?php if ($next) : $image=$next;?>
  	<a href="/<?php echo Request::current()->uri(array('id'=>$image->id,'action'=>false));?>" title="<?php echo $image->name; ?>">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.jpg" alt="image <?php echo $image->name; ?> preview" class="media" />	  
      <p>Next image</p>
  	</a>
  <?php endif; ?>  
  </div>
</div>
</div>



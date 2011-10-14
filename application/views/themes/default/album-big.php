<div class="list clearfix">
  <ul>
	<?php foreach ($images as $key=>$image) : ?>
  <li> 
  	<a href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/600x1000xwidth.<?php echo $image->ext; ?>" alt="image <?php echo $image->name; ?> preview" />
      <span class="number">#<?php echo $image->add_user_id; ?>-<?php echo $image->album_id; ?>-<?php echo $image->id ?></span>
      <span class="magnify">Full size</span>
      <?php echo $image->name; ?> (<?php echo $image->id; ?>)
  	</a>
  	    <?php if ($album->cart) : ?>
  	<a class="awesome small" href="/<?php echo Request::current()->uri(array('controller'=>'buy','action'=>'image','id'=>$image->id));?>/"><span class="buy">Buy me</span></a>
  	    <?php endif; ?>
  </li>
  <?php endforeach; ?>
  </ul>
  <div style="clear:both;">
  <?php echo $pagination->render(); ?>
  <p class="pagination details"><?php echo $pagination->details(); ?></p>
  </div>
</div>

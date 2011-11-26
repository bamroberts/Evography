<section>
<h2><?php echo $album->name; ?></h2>
 
  <div class="grid_12 alpha">
    <?php echo $media; ?>
  </div>
  
  <div class="grid_4 omega">
    <?php echo $album->desc; ?>
    <?php if(Request::initial()!=Request::current()) : ?>
    <p>
      <b>View more from the</b>
      <a class="button" href="<?php echo Route::url($album->id); ?>"><?php echo $album->name; ?></a>
    </p>   
    <?php endif; ?>
    
    <?php if($album->open): ?>
    <p>
      <b>Contribute to this album</b>
      <a class="button" href="<?php echo Route::url($album->id, array('controller'=>'upload')); ?>">Upload your photos</a>
    </p>   
    <?php endif; ?>
    
  </div>
  
</section>
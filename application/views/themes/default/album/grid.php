  <div class="media-grid grid" <?php echo $data; ?>>
    <?php foreach ($images as $key=>$image) : ?>
      <a href="<?php echo Route::url($image->album_id, array('controller'=>'image','id'=>$image->id)); ?>">
         <img src="<?php echo url::image($image,100,100,'crop'); ?>" alt="image <?php echo $image->name; ?> preview" />
      </a>
     <?php endforeach ;?> 
  </div>
  <p class="details"><?php echo $details; ?></p>
  
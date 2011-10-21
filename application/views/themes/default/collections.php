<h3><?php echo $collection->name ?></h3>
<div class="collection media-grid">
  <?php foreach ($collection->children as $key=>$child) : ?>
    <a href="<?php echo Route::url($child->id); ?>" class="<?php echo ($child->password->active)?'private':false; ?>">
      <h3><?php echo $child->name; ?>(<?php echo $child->id; ?>)
        <span><?php echo $child->desc; ?></span>
      </h3>
      <?php //echo html::dynamic_img($child->cover,'medium','3/2'); ?>
      <img src="<?php echo url::image($child->cover->ext,$child->cover->filehash,300,200,'crop'); ?>" alt="image <?php echo $child->cover->name ?>" />
    </a>  
  <?php endforeach; ?>  
  </div>



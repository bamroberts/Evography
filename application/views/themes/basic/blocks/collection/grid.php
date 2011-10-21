<h3><?php echo $collection->name ?></h3>  
<div class="media-grid collection">
  <?php foreach ($collection->children as $key=>$child) : ?>
  <?php if (!$child->published) continue; ?>
    <a href="<?php echo Route::url($child->id); ?>" class="<?php echo $p=($child->password->active)?'private':false; ?>">
      <span class="media">
        <large><?php echo $child->name; ?><?php if ($p) echo " ($p)"; ?></large>
        <small><?php echo $child->desc; ?></small>
        <small class="base">
        <?php if($count=$child->images->count_all()) : ?>
          Contains <?php echo $count; ?> <?php echo Inflector::plural('image',$count); ?></small>
        <?php endif; ?>
        <?php if($count=$child->children->count()) : ?>
          Contains <?php echo $count; ?> <?php echo Inflector::plural('album',$count); ?>
        <?php endif; ?>
        </small>
      </span>
      <?php if(!$child->password->active || $child->password->cover) : ?>
        <img src="/images/dynamic/<?php echo $child->cover->filehash?>/300x200xcrop.jpg" alt="image <?php echo $child->cover->name ?>" />
      <?php endif; ?>
    </a>
  <?php endforeach;?>
</div>


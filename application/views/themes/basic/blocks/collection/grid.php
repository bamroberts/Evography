<div class="media-grid grid">
  <?php foreach ($children as $key=>$child) : ?>
  <?php if (!$child->published) continue; ?>
    <a href="<?php echo Route::url($child->id); ?>" class="<?php echo $p=(Access::permission($child))?false:'private'; ?>">
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
      <?php if(!$p || $child->password->cover) : ?>
        <img src="/images/dynamic/<?php echo $child->cover->filehash?>/300x200xcrop.jpg" alt="image <?php echo $child->cover->name ?>" />
      <?php endif; ?>
    </a>
  <?php endforeach;?>
</div>


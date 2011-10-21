<nav>
 <ul class="breadcrumbs">
  <?php foreach ($node->parents as $parent) : ?>
  <?php if ($parent->level <= $root->level) continue;?>
    <li>
      <a href="<?php echo Route::url($parent->id); ?>">
        <?php echo $parent->name; ?>
      </a> 
    </li>
  <?php endforeach; ?>
  <?php if( Route::url($node->id) != Route::url($node->id,array("controller"=>Request::current()->controller()))   ) : ?>
    <li>
      <a href="<?php echo Route::url($node->id); ?>">
        <?php echo $node->name; ?>
      </a> 
    </li>
  <?php endif; ?>
 </ul>
</nav>






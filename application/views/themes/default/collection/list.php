<div class="media-grid list">
  <?php foreach ($children as $key=>$child) : ?>
  <?php if (!$child->published) continue; ?>
      <a href="<?php echo Route::url($child->id); ?>" class="<?php echo $p=(Access::permission($child))?false:'private'; ?>">
        <span>
          <large class="pull-right"><?php echo Date::long($child->add_date);?></large>
  	      <large class="title">
  	         <strong>
  	           <?php echo $child->name;?>
  	           <?php if ($p) echo " ($p)"; ?>
  	         </strong>
  	      </large>    
  	      <small class="desc"><?php echo $child->name;?></small>
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
	    <img src="/images/dynamic/<?php echo $child->cover->filehash?>/900x250xcrop.jpg" alt="image <?php echo $child->cover->name ?>" />
	      <ul class="preview">
	        <?php $preview=$child->images->limit(9)->find_all() ?>
	        <?php foreach ($preview as $key=>$image):?>
	        <li>
	         <img src="/images/dynamic/<?php echo $image->filehash;?>/50x50xcrop.jpg" alt="image <?php echo $image->name; ?> preview" />
	        </li>
	        <?php endforeach;?>
	      </ul> 
        
      <?php endif; ?>
      </a>
   
    <?php endforeach; ?>
</div>

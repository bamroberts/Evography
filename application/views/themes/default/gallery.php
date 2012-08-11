<div class="gallery" id="node_<?php echo $collection->id; ?>">
  
  <?php foreach ($sections as $key=>$section): ?>
  <?php if (!$section->published) continue; ?>
    <hr />
    <section id="node_<?php echo $key ?>" class="<?php echo $section->type; ?>" style="<?php if(Access::permission($section) || $section->password->cover) : ?>
		background:url(<?php echo url::image($section->cover,1000,1000,'fit'); ?>) no-repeat center center; 
		background-size:100%;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	<?php endif; ?>">
	  <div class="padding fade-down">
	      <a href="<?php echo Route::url($section->id); ?>" class="btn pull-right">
	        View <?php echo $section->type; ?>
	      </a>
	      <h3>
	        <a href="<?php echo Route::url($section->id); ?>">
	          <?php echo $section->name; ?>
	        </a>
	      </h3>
	      <p><?php echo $section->desc;?></p>
	  </div>
	  <div class="padding">
      	<?php echo Request::factory(  Route::url( $section->id, array('format'=>'part') )  )->execute(); ?>
	  </div>
    </section>
 
  <?php endforeach; ?>
</div>

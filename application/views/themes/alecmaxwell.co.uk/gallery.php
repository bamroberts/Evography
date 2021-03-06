<div class="gallery" id="node_<?php echo $collection->id; ?>">
  
  <section class="intro">
    <?php echo facebook::like(Route::URL($collection->id)); ?>
    <h2><?php echo $collection->name; ?></h2>
    <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
    <p><?php echo $collection->desc; ?></p>
  </section>  
  
  <?php foreach ($sections as $key=>$section): ?>
  <?php if (!$section->published) continue; ?>
    <hr />
    <section id="node_<?php echo $key ?>" class="<?php echo $section->type; ?>">
    <h3>
        <a href="<?php echo Route::url($section->id); ?>">
          <?php echo $section->name; ?>
        </a>
      </h3>
      <div class="grid_12 alpha">
      
      <?php echo Request::factory(  Route::url( $section->id, array('format'=>'part') )  )->execute(); ?>
      </div>
      <div class="grid_4 omega">
      <p><?php echo $section->desc;?></p>
      <p>
        <a href="<?php echo Route::url($section->id); ?>" class="btn pull-right">
          View <?php echo $section->type; ?>
        </a>
      </p>
      </div>
    </section>
 
  <?php endforeach; ?>
</div>

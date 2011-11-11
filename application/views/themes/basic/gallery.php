<div class="gallery" id="node_<?php echo $collection->id; ?>">
  
  <section class="intro">
    <?php echo facebook::like(Route::URL($collection->id)); ?>
    <h2><?php echo $collection->name; ?></h2>
    <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'.part')))->execute();?>
    <p><?php echo $collection->desc; ?></p>
  </section>  
  
  <?php foreach ($sections as $key=>$section): ?>
  <?php if (!$section->published) continue; ?>
    <hr />
    <section id="node_<?php echo $key ?>" class="<?php echo $section->type; ?>">
      <a href="<?php echo Route::url($section->id); ?>" class="btn pull-right">
        View <?php echo $section->type; ?>
      </a>
      <h3>
        <a href="<?php echo Route::url($section->id); ?>">
          <?php echo $section->name; ?>
        </a>
      </h3>
      <p><?php echo $section->desc;?></p>
      <?php echo Request::factory(  Route::url( $section->id, array('format'=>'.part') )  )->execute(); ?>
    </section>
 
  <?php endforeach; ?>
</div>

<?php

//inview

//$view = View::factory('login')->bind('form',$form);//
//
//$options=array('prefix'=>'page1_','namespace'=>$this->request->controller());
//$form = Form::factory($colums,$values,$errors,$options);


?>

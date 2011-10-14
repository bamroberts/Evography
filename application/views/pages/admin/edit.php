<form method="post" action="<?php echo Request::initial()->url(); ?>">
  <legend>
  <?php if($data->id) : ?>
     Edit this <?php echo Request::current()->controller(); ?>    
  <?php else: ?>
     Add to this <?php echo Request::current()->controller(); ?>
  <?php endif; ?> 
  </legend>
  <fieldset>
   <?php echo Form::render($columns,$data,$errors); ?>
  </fieldset>
  <div class="actions">
    <a class="button" href="/<?php echo Request::current()->uri(array('action'=>'')); ?>">Back</a>
    <button class="default" type="submit">Save</button>
    <?php if($data->id) : ?>
      <a href="/<?php echo Request::current()->uri(array('action'=>'delete')); ?>" class="button warn">Delete</a> 
    <?php endif; ?> 
  </div>
</form>

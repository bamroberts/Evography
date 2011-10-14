<form method="post" enctype="multipart/form-data" >
<?php if($start_node!=$watermark->id) : ?>
<input type="radio" name="current" value="default" id="current_default"  <?php echo $current=='default'?'checked':false; ?> /> 
<label for="current_default">Inherit from default</label>
  <fieldset>
  <?php if ($default->path) : ?>
    <img src="/<?php echo $default->path; ?>" alt="default watermark file"/>
  <?php else: ?>
    <h2>[No watermark]</h2>
  <?php endif; ?>
  <a href="<?php echo Request::current()->url(array('id'=>$start_node)); ?>">edit default</a>
  </fieldset>
<hr />
<?php endif; ?>
<input type="radio" name="current" value="off" id="current_off" <?php echo $current=='off'?'checked':false; ?>/> <label for="current_off">No watermark</label>

<hr />
<input type="radio" name="current" value="on" id="current_on" <?php echo $current=='on'?'checked':false; ?> /> <label for="current_on">Custom watermark</label>
  <fieldset>
    <?php if ($watermark->path) : ?>
      <img src="/<?php echo $watermark->path; ?>" alt="current watermark file"/>
    <?php endif; ?>
   <?php echo Form::render($columns,$watermark,$errors,array('path','position','opacity')); ?>    
  </fieldset>
<div class="actions">
    <button type="submit">Update Setting</button>
</div> 
  </form>
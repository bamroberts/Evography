<?php if(isset($header)) : ?>
    <?php echo $header; ?>
<?php endif; ?>
<form method="post">
 <fieldset>
  <?php if(isset($inject)) : ?>
    <?php echo $inject; ?>
  <?php endif; ?>
  
  <?php echo Form::render($columns,$data,$errors); ?>
  
  <?php if(isset($submit)) : ?>
    <button type="submit"><?php echo $submit; ?></button>
  <?php endif; ?>
 
 </fieldset>
</form>
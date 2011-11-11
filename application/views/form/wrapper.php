<div class="group <?php echo $error; ?>">
    <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
    <div class="input <?php echo $addon; ?>">
      <?php echo $content; ?>
      <?php if($help) : ?>     
          <span class="help-block"><?php echo $help; ?></span>
      <?php endif; ?>      
    </div>
</div>
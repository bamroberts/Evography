<div class="group <?php echo $error; ?>">
    <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
    <div class="input">
      <textarea rows="3" name="<?php echo $name; ?>" id="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea>
      <span class="help-block"><?php echo $help; ?></span>
    </div>
</div>
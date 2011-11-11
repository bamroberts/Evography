<select id="<?php echo $name; ?>" id="<?php echo $name; ?>">
  <?php if($blank) : ?>
    <option><?php echo $blank; ?></option>
  <?php endif; ?>
  <?php foreach ($options as $value=>$text) : ?>
    <option value="<?php echo $value; ?>"><?php echo $text; ?></option>
  <?php endforeach; ?>
</select>
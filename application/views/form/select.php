<select id="<?php echo $name; ?>" name="<?php echo $name; ?>">
  <?php if($blank) : ?>
    <option><?php echo $blank; ?></option>
  <?php endif; ?>
  <?php foreach ($options as $value=>$text) : ?>
    <option value="<?php echo $value; ?>" <?php if (Arr::get(Request::initial()->post(),$name)==$value) {echo 'selected';} ?> ><?php echo $text; ?></option>
  <?php endforeach; ?>
</select>
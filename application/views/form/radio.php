<ul class="inputs-list">
  <?php foreach ($options as $value=>$text) : ?>
   <li>
    <label>
      <input type="radio" value="<?php echo $value; ?>" name="<?php echo $name; ?>" <?php echo $value ? 'checked' : false; ?>>
      <span><?php echo $text; ?></span>
    </label>
  </li>
  <?php endforeach; ?>
</ul>
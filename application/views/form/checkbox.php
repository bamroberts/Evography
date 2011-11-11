<ul class="inputs-list">
  <?php if($options) : ?>
     <?php foreach ($options as $key=>$text) : ?>
     <li>
      <label>
        <input type="hidden" value="0" name="<?php echo "$name[$key]"; ?>" />
        <input type="checkbox" name="<?php echo "$name[$key]"; ?>" <?php echo $value[$key] ? 'checked' : false; ?> />
        <?php if($text) : ?>
          <span><?php echo $text; ?></span>
        <?php endif; ?>
      </label>
    </li>
    <?php endforeach; ?>
  <?php else: ?>
    <li>
      <label>
        <input type="hidden" value="0" name="<?php echo $name; ?>" />
        <input type="checkbox" name="<?php echo $name; ?>" <?php echo $value ? 'checked' : false; ?>>
        <?php if($placeholder) : ?>
          <span><?php echo $placeholder; ?></span>
        <?php endif; ?>
      </label>
    </li>
  <?php endif; ?>
  </ul>
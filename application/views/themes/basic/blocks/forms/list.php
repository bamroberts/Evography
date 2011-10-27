<div class="group <?php echo $error; ?>">
    <label id="optionsCheckboxes"><?php echo $label; ?></label>
    <div class="input">
      <ul class="inputs-list">
        <?php foreach ($options as $field=>$option) : ?>
        <li>
          <label>
            <input type="hidden" name="optionsCheckboxes" value="0" >
            <input type="checkbox" value="<?php echo 1; ?>" name="<?php echo $field; ?>">
            <span><?php echo $label; ?></span>
          </label>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php if($help) : ?>
      <span class="help-block">
        <?php echo $help; ?>
      </span>
      <?php endif; ?>
    </div>
</div>  